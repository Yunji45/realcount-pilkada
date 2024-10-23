<?php

namespace App\Http\Controllers\Realcount;

use App\Http\Controllers\Controller;
use App\Models\Votec1;
use Illuminate\Http\Request;
use Illuminate\Database\QueryException;
use App\Models\Candidate;
use App\Models\TpsRealcount;
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
        $candidates = Candidate::with('partai', 'election')
            ->get();
        $pollingPlaces = TpsRealcount::all();
        $provinsis = Provinsi::all();
        $title = "Suara Realcount";
        $type = "Tambah";

        return view('dashboard.admin.realcount.vote.create', compact('candidates', 'pollingPlaces', 'title', 'type', 'provinsis'));
        // return $candidates;
    }

    public function store(Request $request)
    {
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

            $tps = TpsRealcount::find($request->tps_realcount_id);
            if ($tps && $tps->fileC1()->exists()) {
                return back()->with('error', 'Voting Untuk TPS Tersebut Sudah Tidak Bisa Dilakukan Karna Sudah Upload File C1.')->withInput();
            }

            $vote_realcount = Votec1::create([
                'candidate_id' => $request->candidate_id,
                'tps_realcount_id' => $request->tps_realcount_id,
                'real_count' => $request->real_count,
                'status' => 'Open'
            ]);
            Log::info('Vote realcount created successfully.', ['vote_realcount' => $vote_realcount]);
            DB::commit();
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Polling place created successfully.',
            //     'data' => $vote_realcount
            // ], 201); // 201 = Created

            return redirect()->route('realcount-vote.index')->with('success', 'Vote cast successfully');
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error occurred while storing vote realcount.', ['exception' => $e->getMessage()]);
            return back()->with('error', 'Vote casting failed');
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
