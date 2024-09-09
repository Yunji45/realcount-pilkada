<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Election;

class ChartController extends Controller
{
    public function getVotesPerPartaiElection()
    {
        // Ambil data suara per partai, pemilu, dan kandidat
        $votesData = DB::table('votes')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('partais', 'candidates.partai_id', '=', 'partais.id')
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->select(
                'partais.name as partai_name',
                'elections.name as election_name',
                'candidates.name as candidate_name',
                DB::raw('SUM(votes.vote_count) as total_votes')
            )
            ->groupBy('partais.name', 'elections.name', 'candidates.name')
            ->get();

        return response()->json($votesData);
    }

    public function getVotesByElection(Request $request)
    {
        $electionId = $request->input('election_id');

        if (!$electionId) {
            return response()->json([]);
        }

        $votesData = DB::table('votes')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('partais', 'candidates.partai_id', '=', 'partais.id')
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->select(
                'partais.name as partai_name',
                'elections.name as election_name',
                'candidates.name as candidate_name',
                DB::raw('SUM(votes.vote_count) as total_votes')
            )
            ->where('candidates.election_id', $electionId)
            ->groupBy('partais.name', 'elections.name', 'candidates.name')
            ->get();

        return response()->json($votesData);
    }

    public function getElections()
    {
        $elections = Election::select('id', 'name')->get();
        return response()->json($elections);
    }

}
