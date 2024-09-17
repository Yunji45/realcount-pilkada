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

    public function build($filter = []): \ArielMejiaDev\LarapexCharts\PieChart
    {
        // Get data from the database with optional filtering
        $query = Vote::selectRaw('partais.name as partai_name, partais.color as partai_color, SUM(votes.vote_count) as total_votes')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('partais', 'candidates.partai_id', '=', 'partais.id') // Join with partai table to get partai name and color
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id') // Join with polling_places to apply filters
            ->where('elections.type', 'Partai')
            ->groupBy('partais.name', 'partais.color');

        // Apply filters (for province, kabupaten, kecamatan, kelurahan, and election)
        if (!empty($filter['provinsi_id'])) {
            $query->where('polling_places.provinsi_id', $filter['provinsi_id']);
        }
        if (!empty($filter['kabupaten_id'])) {
            $query->where('polling_places.kabupaten_id', $filter['kabupaten_id']);
        }
        if (!empty($filter['kecamatan_id'])) {
            $query->where('polling_places.kecamatan_id', $filter['kecamatan_id']);
        }
        if (!empty($filter['kelurahan_id'])) {
            $query->where('polling_places.kelurahan_id', $filter['kelurahan_id']);
        }
        if (isset($filter['election_id']) && $filter['election_id']) {
            $query->where('elections.id', $filter['election_id']);
        }
        $votes = $query->get();

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
