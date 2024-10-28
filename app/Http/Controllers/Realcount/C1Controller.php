<?php

namespace App\Http\Controllers\Realcount;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Filec1;
use App\Models\Election;
use App\Models\Vote;
use App\Models\Provinsi;
use App\Models\TpsRealcount;
use App\Models\Votec1;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class C1Controller extends Controller
{
    public function getCandidatesByElection($election_id)
    {
        $candidates = Candidate::where('election_id', $election_id)->get();
        return response()->json($candidates);
    }

    //revisi pada pembagian role berdasarkan role dan dibuat 1 page
    public function index(Request $request)
    {
        $title = 'File C1';
        $length = max((int) $request->input('length', 10), 1);
        $start = (int) $request->input('start', 0);
        $page = intval($start / $length) + 1;
        $votes = Filec1::with('tpsrealcount.kelurahan', 'tpsrealcount.kecamatan')
            ->paginate($length, ['*'], 'page', $page);
        $data = $votes->items();
        foreach ($data as $vote) {
            $vote->file = Storage::url($vote->file);
        }
        if ($request->ajax()) {
            return response()->json([
                'draw' => intval($request->input('draw', 0)),
                'recordsTotal' => $votes->total(),
                'recordsFiltered' => $votes->total(),
                'data' => $votes->items()
            ]);
        }
        return view('dashboard.admin.realcount.c1.index', compact('title'));
    }

    public function create()
    {
        $title = 'File C1';
        $type = 'Tambah';
        $pollingPlaces = TpsRealcount::all();
        $usedElectionIds = Vote::pluck('candidate_id')
                            ->unique()
                            ->map(function ($candidateId) {
                                return Candidate::where('id', $candidateId)->value('election_id');
                            })
                            ->filter()
                            ->unique();
        // $pemilihan = Election::all();
        $pemilihan = Election::whereNotIn('id', $usedElectionIds)->get();
        $provinsis = Provinsi::all();
        return view('dashboard.admin.realcount.c1.create', compact('title', 'type', 'pollingPlaces', 'provinsis', 'pemilihan'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'tps_realcount_id' => 'required|exists:tps_realcounts,id',
                'file' => 'required|file|mimes:jpeg,png,pdf|max:5120',
                'election_id' => 'required|exists:elections,id'
            ]);

            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('File_C1', 'public');
                Log::info('File berhasil disimpan.', ['path' => $path]);

                foreach ($request->votes as $candidateId => $voteCount) {
                    $existingVote = Votec1::where('candidate_id', $candidateId)->first();
                    if ($existingVote) {
                        return back()->with('error', 'Salah satu kandidat ini sudah memiliki suara dan tidak dapat memberikan suara lagi.')->withInput();
                    }
                    $candidate = Candidate::find(id:  $candidateId);
                    $hasFileC1 = filec1::where('election_id', $candidate->election_id)
                        ->where('tps_realcount_id', $request->tps_realcount_id)
                        ->exists();
            
                    if ($hasFileC1) {
                        return back()->with('error', 'Voting tidak dapat dilakukan karena file C1 untuk TPS terkait dan pemilihan sudah ada.')->withInput();
                    }
    
                    Votec1::create([
                        'candidate_id' => $candidateId,
                        'tps_realcount_id' => $request->tps_realcount_id,
                        'real_count' => $voteCount,
                        'status' => "Open",
                        'created_at' => now()
                    ]);
                }    
                Filec1::create([
                    'tps_realcount_id' => $request->tps_realcount_id,
                    'file' => $path,
                    'election_id' => $request->election_id,
                    'created_at' => now()
                ]);
                DB::commit();
                Log::info('File C1 berhasil diupload.', ['tps_realcount_id' => $request->tps_realcount_id]);
                return redirect()->route('file-c1.index')->with('success', 'File C1 dan Vote suara berhasil diupload.');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            // dd($th->getMessage());
            Log::error('Gagal mengupload file.', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Gagal mengupload file.');
        }
    }

    public function show($id)
    {
    }

    public function edit($id)
    {
    }

    public function update(Request $request, $id)
    {
    }

    public function destroy($file_c1)
    {
        DB::beginTransaction();
        try {
            $fileC1 = Filec1::findOrFail($file_c1);
            if (Storage::disk('public')->exists($fileC1->file)) {
                Storage::disk('public')->delete($fileC1->file);
                Log::info('File berhasil dihapus dari storage.', ['path' => $fileC1->file]);
            } else {
                Log::warning('File tidak ditemukan di storage.', ['path' => $fileC1->file]);
            }
            $fileC1->delete();
            DB::commit();

            Log::info('File C1 berhasil dihapus.', ['id' => $file_c1]);
            return redirect()->route('file-c1.index')->with('success', 'File C1 berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal menghapus file.', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menghapus file.');
        }
    }
}
