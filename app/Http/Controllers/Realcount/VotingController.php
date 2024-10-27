<?php

namespace App\Http\Controllers\Realcount;

use App\Http\Controllers\Controller;
use App\Models\Votec1;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Candidate;
use App\Models\TpsRealcount;
use App\Models\filec1;
use App\Models\Vote;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;


class VotingController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10);
        if ($length <= 0) {
            $length = 10;
        }
        $page = ($request->start / $length) + 1;
        $votes = Votec1::with('candidate.partai', 'tpsrealcount.kelurahan', 'tpsrealcount.kecamatan', 'candidate.election')
            ->paginate($length, ['*'], 'page', $page);
        if ($request->ajax()) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $votes->total(),
                'recordsFiltered' => $votes->total(),
                'data' => $votes->items()
            ]);
        }

        $title = "Suara Realcount";

        return view('dashboard.admin.realcount.vote.index', compact('title'));
    }

    public function create()
    {
        $candidateIds = Vote::pluck('candidate_id');
        $candidates = Candidate::whereNotIn('id', $candidateIds)->get();
        $pollingPlaces = TpsRealcount::all();
        $provinsis = Provinsi::all();
        $title = "Suara Realcount";
        $type = "Tambah";

        return view('dashboard.admin.realcount.vote.create', compact('candidates', 'pollingPlaces', 'title', 'type', 'provinsis'));
        // return $candidates;
    }

    public function store(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'candidate_id' => ['required', 'exists:candidates,id'],
            'tps_realcount_id' => ['required', 'exists:polling_places,id'],
            'real_count' => ['required', 'string', 'max:255'],
        ]);

        // Jika validasi gagal, langsung kembalikan dengan error
        if ($validator->fails()) {
            Log::warning('Validation failed.', ['errors' => $validator->errors()]);
            return back()->withErrors($validator)->withInput();
        }

        // Mulai transaksi setelah validasi berhasil
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'candidate_id' => ['required', 'exists:candidates,id'],
                'tps_realcount_id' => ['required', 'exists:polling_places,id'],
                'real_count' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                Log::warning('Validation failed.', ['errors' => $validator->errors()]);
                return back()->withErrors($validator)->withInput();
            }
            $existingVote = Votec1::where('candidate_id', $request->candidate_id)->first();
            if ($existingVote) {
                return back()->with('error', 'Kandidat ini sudah memiliki suara dan tidak dapat memberikan suara lagi.')->withInput();
            }
            // $tps = TpsRealcount::find($request->tps_realcount_id);
            // if ($tps && $tps->fileC1()->exists()) {
            //     return back()->with('error', 'Voting Untuk TPS Tersebut Sudah Tidak Bisa Dilakukan Karna Sudah Upload File C1.')->withInput();
            // }
            $candidate = Candidate::find(id:  $request->candidate_id);
            $hasFileC1 = filec1::where('election_id', $candidate->election_id)
                ->where('tps_realcount_id', $request->tps_realcount_id)
                ->exists();
    
            if ($hasFileC1) {
                return back()->with('error', 'Voting tidak dapat dilakukan karena file C1 untuk TPS terkait dan pemilihan sudah ada.')->withInput();
            }
            $vote_realcount = Votec1::create([
                'candidate_id' => $request->candidate_id,
                'tps_realcount_id' => $request->tps_realcount_id,
                'real_count' => $request->real_count,
                'status' => 'Open'
            ]);

            Log::info('Vote realcount created successfully.', ['vote_realcount' => $vote_realcount]);

            // Commit transaksi setelah semua berhasil
            DB::commit();

            return redirect()->route('realcount-vote.index')->with('success', 'Vote cast successfully');
        } catch (\Exception $e) {
            // Rollback jika ada kesalahan
            DB::rollBack();
            Log::error('Error occurred while storing vote realcount.', ['exception' => $e->getMessage()]);
            return back()->with('error', 'Vote casting failed')->withInput();
        }
    }

    public function show(Votec1 $vote_realcount)
    {
        $candidates = Candidate::with('partai', 'election')
            ->get();
        $pollingPlaces = TpsRealcount::all();
        $title = "Suara";
        $type = "Detail Data";

        return view('dashboard.admin.vote.show', compact('candidates', 'pollingPlaces', 'title', 'type'));
        // return $vote_realcount;
    }

    public function edit(Votec1 $vote_realcount)
    {
        $candidates = Candidate::with('partai', 'election')
            ->get();
        $pollingPlaces = TpsRealcount::all();
        $provinsis = Provinsi::all();
        $title = "Suara Realcount";
        $type = "Edit Data";

        return view('dashboard.admin.realcount.vote.edit', compact('candidates', 'pollingPlaces', 'title', 'type', 'vote_realcount', 'provinsis'));
        // return $vote_realcount;
    }

    public function update(Request $request, Votec1 $vote_realcount)
    {
        // Mulai transaksi
        DB::beginTransaction();
        try {
            $validatedData = $request->validate([
                'candidate_id' => ['nullable', 'exists:candidates,id'], // Tidak wajib diisi
                'tps_realcount_id' => ['nullable', 'exists:polling_places,id'], // Tidak wajib diisi
                'real_count' => ['nullable', 'integer'], // Tidak wajib diisi
            ]);
            $vote_realcount->update(array_filter($validatedData)); // Hanya kolom yang tidak null yang akan diupdate
            DB::commit();
            return redirect()->route('vote-realcount.index')->with('success', 'Vote updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Vote update failed: ' . $th->getMessage());
            return back()->with('error', 'Vote update failed')->withInput();
        }
    }

    public function destroy(Votec1 $vote_realcount)
    {
        DB::beginTransaction();
        try {
            $vote_realcount->delete();

            DB::commit();

            return redirect()->route('vote-realcount.index')->with('success', 'Vote deleted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', 'Vote deletion failed. The vote is still referenced in another table.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'An unexpected error occurred.');
        }
    }

    public function getTpsRealcount($kelurahanId)
    {
        $pollingPlaces = TpsRealcount::where('kelurahan_id', $kelurahanId)->get();
        return response()->json($pollingPlaces);
    }
}
