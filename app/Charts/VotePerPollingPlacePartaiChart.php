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
        $query = Vote::selectRaw('polling_places.name as polling_place_name, partais.name as partai_name, partais.color as partai_color, SUM(votes.vote_count) as total_votes')
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('partais', 'candidates.partai_id', '=', 'partais.id') // Join with partai to get name and color
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->where('elections.type', 'Partai') // Filter for 'Partai' type elections
            ->groupBy('polling_places.name', 'partais.name', 'partais.color'); // Group by TPS and Partai

        // Apply filters (for province, kabupaten, kecamatan, kelurahan, and election)
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

        // Group data by polling places (TPS)
        $pollingPlaces = $votes->groupBy('polling_place_name');
        $labels = $pollingPlaces->keys()->toArray(); // TPS names as labels

        // Prepare data for each partai, with partai color
        $series = [];
        $partais = $votes->groupBy('partai_name')->keys()->toArray(); // Get partai names

        foreach ($partais as $partai) {
            $data = [];
            $color = null;

            foreach ($labels as $pollingPlace) {
                // Get vote count for this partai at this polling place
                $vote = $pollingPlaces->get($pollingPlace)->where('partai_name', $partai)->first();
                $data[] = $vote ? $vote->total_votes : 0;

                // Get the partai color
                if ($vote && !$color) {
                    $color = $vote->partai_color;
                }
            }

            // Add partai data to series with partai color
            $series[] = [
                'name' => $partai,
                'data' => $data,
                'color' => $color, // Apply partai color to the series
            ];
        }

        return $this->chart->barChart()
            ->setTitle('Jumlah Suara per TPS per Partai')
            ->setSubtitle('Filter berdasarkan Wilayah dan Pemilu')
            ->setLabels($labels) // TPS names
            ->setWidth('1200')
            ->setHeight('400')
            ->setDataset($series); // Partai votes data
    }
}
