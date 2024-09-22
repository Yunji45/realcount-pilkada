<?php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Vote;

class VotePerorangChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filter = []): \ArielMejiaDev\LarapexCharts\PieChart
    {
        // Prepare the query
        $query = Vote::selectRaw('candidates.name as candidate_name, SUM(votes.vote_count) as total_votes')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->where('elections.type', 'Perorang');

        // Apply the filter for RW if provided
        if (!empty($filter['rw_id'])) {
            $query->where('votes.rw', $filter['rw_id']);
        }

        // Group the results by the candidate's name
        $votes = $query->groupBy('candidates.name')->get();

        // Prepare data for chart
        $labels = $votes->pluck('candidate_name')->toArray(); // Extract names for labels
        $data = $votes->pluck('total_votes')->toArray(); // Extract total votes for data

        // Build and return the pie chart
        return $this->chart->pieChart()
            ->addData($data)
            ->setLabels($labels)
            ->setWidth('400')
            ->setHeight('400');
    }

}
