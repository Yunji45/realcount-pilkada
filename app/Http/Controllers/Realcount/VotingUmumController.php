<?php

namespace App\Http\Controllers\Realcount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Candidate;

class VotingUmumController extends Controller
{
    public function createformindex()
    {
        $candidateIdsWithVotes = Vote::pluck('candidate_id');
        $candidatesWithoutVotes = Candidate::whereNotIn('id', $candidateIdsWithVotes)->select('id')->get();
        return response()->json($candidatesWithoutVotes);
    }

    public function create()
    {
        $title = 'Voting Quick Count';
        return view('dashboard.admin.realcount.vote-umum.create',compact('title'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'real_count.*' => 'required|numeric',
            'candidate_id.*' => 'required|exists:candidates,id',
        ]);
        foreach ($data['real_count'] as $index => $realCount) {
            Vote::create([
                'real_count' => $realCount,
                'candidate_id' => $data['candidate_id'][$index],
            ]);
        }
        return redirect()->route('realcount-vote.index')->with('success', 'Votes have been counted.');
    }
}
