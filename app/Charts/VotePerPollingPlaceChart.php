<?php

// app/Charts/VotePerPollingPlaceChart.php

namespace App\Charts;

use ArielMejiaDev\LarapexCharts\LarapexChart;
use App\Models\Vote;

class VotePerPollingPlaceChart
{
    protected $chart;

    public function __construct(LarapexChart $chart)
    {
        $this->chart = $chart;
    }

    public function build($filter = []): \ArielMejiaDev\LarapexCharts\BarChart
    {
        // Get data from the database with filtering options
        $query = Vote::selectRaw('polling_places.name as polling_place_name, SUM(votes.vote_count) as total_votes')
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->groupBy('polling_places.name');

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

        $votes = $query->get();

        // Prepare data for chart
        $labels = $votes->pluck('polling_place_name')->toArray();
        $data = $votes->pluck('total_votes')->toArray();

        return $this->chart->barChart()
            ->addData('Jumlah Suara', $data)
            ->setTitle('Jumlah Suara per TPS')
            ->setSubtitle('Filter berdasarkan Wilayah')
            ->setLabels($labels)
            ->setWidth('1200')
            ->setHeight('400');
    }
}
