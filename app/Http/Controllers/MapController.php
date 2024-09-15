<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;
use App\Models\Vote;
use Illuminate\Support\Facades\DB;


class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $votes = Vote::select(
            'votes.vote_count',
            'candidates.name as candidate_name',
            'elections.name as election_name',
            'partais.name as partai_name',
            'partais.color as partai_color',
            'polling_places.name as polling_place_name',
            'polling_places.latitude',
            'polling_places.longitude',
            'provinsis.name as provinsi_name',
            'kabupatens.name as kabupaten_name',
            'kecamatans.name as kecamatan_name',
            'kelurahans.name as kelurahan_name'
        )
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('partais', 'candidates.partai_id', '=', 'partais.id')
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->join('provinsis', 'polling_places.provinsi_id', '=', 'provinsis.id')
            ->join('kabupatens', 'polling_places.kabupaten_id', '=', 'kabupatens.id')
            ->join('kecamatans', 'polling_places.kecamatan_id', '=', 'kecamatans.id')
            ->join('kelurahans', 'polling_places.kelurahan_id', '=', 'kelurahans.id')
            ->get();

        return response()->json($votes);

    }

    public function tes(Request $request)
    {
        // Sub-query untuk mendapatkan TPS dengan suara terbanyak di setiap kelurahan
        $subQuery = Vote::select(
            'polling_places.kelurahan_id',
            'polling_places.latitude',
            'polling_places.longitude',
            DB::raw('SUM(votes.vote_count) as total_vote_per_tps')
        )
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->groupBy('polling_places.id', 'polling_places.kelurahan_id', 'polling_places.latitude', 'polling_places.longitude')
            ->orderBy('total_vote_per_tps', 'desc');

        // Query utama untuk mendapatkan suara gabungan per kelurahan dan titik koordinat TPS dengan suara terbanyak per partai
        $votes = Vote::select(
            'kelurahans.name as kelurahan_name',
            'kecamatans.name as kecamatan_name',
            'kabupatens.name as kabupaten_name',
            'provinsis.name as provinsi_name',
            'top_tps.latitude',
            'top_tps.longitude',
            'partais.name as partai_name',
            'partais.color as partai_color',
            DB::raw('SUM(votes.vote_count) as total_vote_per_partai')
        )
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('partais', 'candidates.partai_id', '=', 'partais.id')
            ->join('elections', 'candidates.election_id', '=', 'elections.id')
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->join('provinsis', 'polling_places.provinsi_id', '=', 'provinsis.id')
            ->join('kabupatens', 'polling_places.kabupaten_id', '=', 'kabupatens.id')
            ->join('kecamatans', 'polling_places.kecamatan_id', '=', 'kecamatans.id')
            ->join('kelurahans', 'polling_places.kelurahan_id', '=', 'kelurahans.id')
            // Gabungkan dengan subquery TPS suara terbanyak
            ->joinSub($subQuery, 'top_tps', function ($join) {
                $join->on('polling_places.kelurahan_id', '=', 'top_tps.kelurahan_id');
            })
            ->groupBy(
                'kelurahans.name',
                'kecamatans.name',
                'kabupatens.name',
                'provinsis.name',
                'top_tps.latitude',
                'top_tps.longitude',
                'partais.name',
                'partais.color'
            )
            ->get();

        // Mengelompokkan hasil berdasarkan kelurahan, kecamatan, kabupaten, provinsi, latitude, dan longitude
        $groupedVotes = $votes->groupBy(function ($item) {
            return $item->kelurahan_name . '_' . $item->kecamatan_name . '_' . $item->kabupaten_name . '_' . $item->provinsi_name . '_' . $item->latitude . '_' . $item->longitude;
        });

        $result = [];
        foreach ($groupedVotes as $key => $voteGroup) {
            $firstItem = $voteGroup->first(); // Ambil detail wilayah dari item pertama di grup
            $parties = [];

            // Looping partai di dalam kelompok wilayah yang sama
            foreach ($voteGroup as $vote) {
                $parties[] = [
                    'partai_name' => $vote->partai_name,
                    'partai_color' => $vote->partai_color,
                    'total_votes' => $vote->total_vote_per_partai
                ];
            }

            // Buat entry hasil dengan mengelompokkan berdasarkan wilayah
            $result[] = [
                'kelurahan_name' => $firstItem->kelurahan_name,
                'kecamatan_name' => $firstItem->kecamatan_name,
                'kabupaten_name' => $firstItem->kabupaten_name,
                'provinsi_name' => $firstItem->provinsi_name,
                'latitude' => $firstItem->latitude,
                'longitude' => $firstItem->longitude,
                'parties' => $parties
            ];
        }

        return response()->json($result);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Map $map)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Map $map)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Map $map)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Map $map)
    {
        //
    }

    public function map()
    {
        return view('map');
    }
}
