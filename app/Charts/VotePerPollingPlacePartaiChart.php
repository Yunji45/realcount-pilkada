<?php

namespace App\Charts;

use App\Models\Vote;
use ArielMejiaDev\LarapexCharts\LarapexChart;

class VotePerPollingPlacePartaiChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filter = []): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Get data from the database with filtering options
        $query = Vote::selectRaw('polling_places.name as polling_place_name, candidates.name as candidate_name, SUM(votes.vote_count) as total_votes')
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->where('elections.type', 'Partai') // Filter hanya kandidat dengan type 'Perorang'
            ->groupBy('polling_places.name', 'candidates.name');

        if (isset($filter['provinsi_id']) && $filter['provinsi_id']) {
            $query->where('polling_places.provinsi_id', $filter['provinsi_id']);
        }
        if (isset($filter['kabupaten_id']) && $filter['kabupaten_id']) {
            $query->where('polling_places.kabupaten_id', $filter['kabupaten_id']);
        }
        if (isset($filter['kecamatan_id']) && $filter['kecamatan_id']) {
            $query->where('polling_places.kecamatan_id', $filter['kecamatan_id']);
        }
        if (isset($filter['kelurahan_id']) && $filter['kelurahan_id']) {
            $query->where('polling_places.kelurahan_id', $filter['kelurahan_id']);
        }
        if (isset($filter['election_id']) && $filter['election_id']) {
            $query->where('elections.id', $filter['election_id']);
        }

        $votes = $query->get();

        // Prepare data for chart
        $pollingPlaces = $votes->groupBy('polling_place_name');
        $labels = $pollingPlaces->keys()->toArray();

        // Prepare data for each candidate
        $series = [];
        $candidates = $votes->groupBy('candidate_name')->keys()->toArray();

        foreach ($candidates as $candidate) {
            $data = [];
            foreach ($labels as $pollingPlace) {
                $vote = $pollingPlaces->get($pollingPlace)->where('candidate_name', $candidate)->first();
                $data[] = $vote ? $vote->total_votes : 0;
            }
            $series[] = [
                'name' => $candidate,
                'data' => $data
            ];
        }

        return $this->chart->barChart()
            ->setTitle('Jumlah Suara per TPS per Kandidat (Partai)')
            ->setSubtitle('Filter berdasarkan Wilayah dan Pemilu')
            ->setLabels($labels)
            ->setWidth('1200')
            ->setHeight('400')
            ->setDataset($series);
    }
}
