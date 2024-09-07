<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
use App\Models\PollingPlace;
use App\Models\Vote;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
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
        $pollingPlaces = PollingPlace::all();
        $title = "Suara";
        $type = "Tambah Data";

        return view('dashboard.admin.vote.create', compact('candidates', 'pollingPlaces', 'title', 'type'));
        // return $votes;
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

            return redirect()->route('vote.index')->with('success', 'Vote cast successfully');
        } catch (\Throwable $th) {
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
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Vote deletion failed');
        }
    }
}
