<?php

namespace App\Http\Controllers;

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
        $votes = Vote::all();

        // return view('');
        return $votes;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $votes = Vote::all();

        // return view('');
        return $votes;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'exists:users,id'],
                'candidate_id' => ['required', 'exists:candidates,id'],
                'election_id' => ['required', 'exists:elections,id'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $vote = Vote::create([
                'user_id' => $request->user_id,
                'candidate_id' => $request->candidate_id,
                'election_id' => $request->election_id,
            ]);

            DB::commit();

            return redirect()->route('votes.index')->with('success', 'Vote cast successfully');
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
        // return view('');
        return $vote;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vote $vote)
    {
        // return view('');
        return $vote;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vote $vote)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'user_id' => ['required', 'exists:users,id'],
                'candidate_id' => ['required', 'exists:candidates,id'],
                'election_id' => ['required', 'exists:elections,id'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $vote->update([
                'user_id' => $request->user_id,
                'candidate_id' => $request->candidate_id,
                'election_id' => $request->election_id,
            ]);

            DB::commit();

            return redirect()->route('votes.index')->with('success', 'Vote updated successfully');
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

            return redirect()->route('votes.index')->with('success', 'Vote deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Vote deletion failed');
        }
    }
}
