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
            ->join('partais', 'candidates.partai_id', '=', 'partais.id')
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
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
        if (!empty($filter['rw_id'])) {
            $query->where('polling_places.rw', operator: $filter['rw_id']);
        }
        if (!empty($filter['election_id'])) {
            $query->where('elections.id', $filter['election_id']);
        }

        $votes = $query->get();

        // Calculate the total number of votes
        $totalVotes = $votes->sum('total_votes');

        // Prepare data for chart
        $labels = $votes->map(function ($vote) use ($totalVotes) {
            $percentage = $totalVotes > 0 ? round(($vote->total_votes / $totalVotes) * 100, 2) : 0;
            return $vote->partai_name . ' (' . $percentage . '%)';
        })->toArray();

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
