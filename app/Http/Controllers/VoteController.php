<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\PollingPlace;
use App\Models\Vote;
use Illuminate\Database\QueryException;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $votes = Vote::with('candidate.partai', 'polling_place')
            ->get();
        $title = "Suara";

        return view('dashboard.admin.vote.index', compact('votes', 'title'));
        // return $votes;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $candidates = Candidate::with('partai', 'election')
            ->get();
        // $candidates = Candidate::all();
        $pollingPlaces = PollingPlace::all();
        $provinsis = Provinsi::all();
        $title = "Suara";
        $type = "Tambah Data";

        return view('dashboard.admin.vote.create', compact('candidates', 'pollingPlaces', 'title', 'type', 'provinsis'));
        // return $candidates;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'candidate_id' => ['required', 'exists:candidates,id'],
                'polling_place_id' => ['required', 'exists:polling_places,id'],
                'vote_count' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $vote = Vote::create([
                'candidate_id' => $request->candidate_id,
                'polling_place_id' => $request->polling_place_id,
                'vote_count' => $request->vote_count,
            ]);

            DB::commit();
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Polling place created successfully.',
            //     'data' => $vote
            // ], 201); // 201 = Created

            return redirect()->route('vote.index')->with('success', 'Vote cast successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Vote casting failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vote $vote)
    {
        $candidates = Candidate::with('partai', 'election')
            ->get();
        $pollingPlaces = PollingPlace::all();
        $title = "Suara";
        $type = "Detail Data";

        return view('dashboard.admin.vote.show', compact('candidates', 'pollingPlaces', 'title', 'type'));
        // return $vote;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vote $vote)
    {
        $candidates = Candidate::with('partai', 'election')
            ->get();
        $pollingPlaces = PollingPlace::all();
        $title = "Suara";
        $type = "Edit Data";

        return view('dashboard.admin.vote.edit', compact('candidates', 'pollingPlaces', 'title', 'type'));
        // return $vote;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vote $vote)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'candidate_id' => ['required', 'exists:candidates,id'],
                'polling_place_id' => ['required', 'exists:polling_places,id'],
                'vote_count' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $vote->update([
                'candidate_id' => $request->candidate_id,
                'polling_place_id' => $request->polling_place_id,
                'vote_count' => $request->vote_count,
            ]);

            DB::commit();

            return redirect()->route('vote.index')->with('success', 'Vote updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Vote update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Vote $vote)
    {
        DB::beginTransaction();
        try {
            $vote->delete();

            DB::commit();

            return redirect()->route('vote.index')->with('success', 'Vote deleted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', 'Vote deletion failed. The vote is still referenced in another table.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'An unexpected error occurred.');
        }
    }

    public function getKabupatens($provinsi_id)
    {
        $kabupatens = Kabupaten::where('provinsi_id', $provinsi_id)->get();
        return response()->json($kabupatens);
    }

    // Mendapatkan kecamatan berdasarkan kabupaten (AJAX)
    public function getKecamatans($kabupaten_id)
    {
        $kecamatans = Kecamatan::where('kabupaten_id', $kabupaten_id)->get();
        return response()->json($kecamatans);
    }

    // Mendapatkan kelurahan berdasarkan kecamatan (AJAX)
    public function getKelurahans($kecamatan_id)
    {
        $kelurahans = Kelurahan::where('kecamatan_id', $kecamatan_id)->get();
        return response()->json($kelurahans);
    }

    // Mendapatkan polling places berdasarkan kelurahan (AJAX)
    public function getPollingPlaces($kelurahan_id)
    {
        $pollingPlaces = PollingPlace::where('kelurahan_id', $kelurahan_id)->get();
        return response()->json($pollingPlaces);
    }
}
