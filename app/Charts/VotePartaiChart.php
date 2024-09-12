<?php

namespace App\Charts;

use App\Models\Vote;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class VotePartaiChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build(): \ArielMejiaDev\LarapexCharts\PieChart
    {
        // Get data from the database
        $votes = Vote::selectRaw('partais.name as partai_name, partais.color as partai_color, SUM(votes.vote_count) as total_votes')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('partais', 'candidates.partai_id', '=', 'partais.id') // Join with partais table to get partai name and color
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->where('elections.type', 'Partai')
            ->groupBy('partais.name', 'partais.color') // Group by partai name and color
            ->get();

        // Prepare data for chart
        $labels = $votes->pluck('partai_name')->toArray(); // Extract partai names for labels
        $data = $votes->pluck('total_votes')->toArray(); // Extract total votes for data
        $colors = $votes->pluck('partai_color')->toArray(); // Extract colors from partai for chart colors

        return $this->chart->pieChart()
            ->addData($data)
            ->setLabels($labels)
            ->setColors($colors) // Set colors based on the 'color' field from the partai table
            ->setWidth('400')
            ->setHeight('400');
    }
}
