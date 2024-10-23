<?php

namespace App\Http\Controllers\Realcount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Votec1;
use App\Models\Provinsi;
use App\Models\Candidate;
use App\Models\TpsRealcount;

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
        $type = 'Voting Umum';
        $pollingPlaces = TpsRealcount::all();
        $provinsis = Provinsi::all();
        $candidateIds = Vote::pluck('candidate_id');
        $candidatesWithout = Candidate::whereNotIn('id', $candidateIds)->get();
        return view('dashboard.admin.realcount.vote-umum.create',compact('title','type','candidatesWithout','provinsis','pollingPlaces'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'real_count.*' => 'required|numeric',
            'candidate_id.*' => 'required|exists:candidates,id',
            'tps_realcount_id.*' => 'required',
        ]);

        foreach ($data['candidate_id'] as $index => $candidateId) {
            $existingVote = Votec1::where('candidate_id', $candidateId)
                                ->where('tps_realcount_id', $data['tps_realcount_id'][$index])
                                ->first();
            if ($existingVote) {
                return redirect()->back()->with('error', 'Kandidat dengan ID ' . $candidateId . ' sudah memiliki data di TPS yang dipilih.')->withInput();
            }
            Votec1::create([
                'real_count' => $data['real_count'][$index],
                'candidate_id' => $candidateId,
                'tps_realcount_id' => $data['tps_realcount_id'][$index],
            ]);
        }
        return redirect()->route('realcount-vote.index')->with('success', 'Votes have been counted.');
    }

}
