<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;
use App\Models\Vote;
use App\Models\Partai;
use Illuminate\Support\Facades\DB;


class MapController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Subquery untuk mendapatkan TPS dengan suara terbanyak di setiap RW di setiap kelurahan
        $subQuery = Vote::select(
            'polling_places.kelurahan_id',
            'polling_places.rw',
            'polling_places.latitude',
            'polling_places.longitude',
            DB::raw('SUM(votes.vote_count) as total_vote_per_tps')
        )
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->groupBy('polling_places.kelurahan_id', 'polling_places.rw', 'polling_places.latitude', 'polling_places.longitude')
            ->orderBy('total_vote_per_tps', 'desc');

        // Query utama untuk mendapatkan suara gabungan per RW dan TPS suara terbanyak per partai
        $votes = Vote::select(
            'kelurahans.name as kelurahan_name',
            'kecamatans.name as kecamatan_name',
            'kabupatens.name as kabupaten_name',
            'provinsis.name as provinsi_name',
            'top_tps.latitude',
            'top_tps.longitude',
            DB::raw('SUM(polling_places.DPT) as total_dpt'), // Total DPT per RW
            'polling_places.rw',
            'partais.name as partai_name',
            'partais.color as partai_color',
            DB::raw('SUM(votes.vote_count) as total_vote_per_partai'),
            DB::raw('(SUM(votes.vote_count) / SUM(polling_places.DPT)) * 100 as vote_percentage') // Persentase suara
        )
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('partais', 'candidates.partai_id', '=', 'partais.id')
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->join('kelurahans', 'polling_places.kelurahan_id', '=', 'kelurahans.id')
            ->join('kecamatans', 'polling_places.kecamatan_id', '=', 'kecamatans.id')
            ->join('kabupatens', 'polling_places.kabupaten_id', '=', 'kabupatens.id')
            ->join('provinsis', 'polling_places.provinsi_id', '=', 'provinsis.id')
            // Gabungkan dengan subquery TPS suara terbanyak
            ->joinSub($subQuery, 'top_tps', function ($join) {
                $join->on('polling_places.kelurahan_id', '=', 'top_tps.kelurahan_id')
                    ->on('polling_places.rw', '=', 'top_tps.rw'); // Gabungkan berdasarkan RW
            })
            ->groupBy(
                'kelurahans.name',
                'kecamatans.name',
                'kabupaten_name',
                'provinsis.name',
                'top_tps.latitude',
                'top_tps.longitude',
                'polling_places.rw',
                'partais.name',
                'partais.color'
            )
            ->get();

        // Mengelompokkan hasil berdasarkan kelurahan, kecamatan, kabupaten, provinsi, latitude, longitude, dan RW
        $groupedVotes = $votes->groupBy(function ($item) {
            return $item->kelurahan_name . '_' . $item->kecamatan_name . '_' . $item->kabupaten_name . '_' . $item->provinsi_name . '_' . $item->rw . '_' . $item->latitude . '_' . $item->longitude;
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
                    'total_votes' => $vote->total_vote_per_partai,
                    'vote_percentage' => round($vote->vote_percentage, 2) // Persentase suara dibulatkan ke 2 desimal
                ];
            }
            usort($parties, function($a, $b) {
                return $b['total_votes'] <=> $a['total_votes'];
            });
    

            // Buat entry hasil dengan mengelompokkan berdasarkan wilayah
            $result[] = [
                'kelurahan_name' => $firstItem->kelurahan_name,
                'kecamatan_name' => $firstItem->kecamatan_name,
                'kabupaten_name' => $firstItem->kabupaten_name,
                'provinsi_name' => $firstItem->provinsi_name,
                'rw' => $firstItem->rw,
                'latitude' => $firstItem->latitude,
                'longitude' => $firstItem->longitude,
                'total_dpt' => $firstItem->total_dpt,  // Mengambil total DPT per RW
                'parties' => $parties
            ];
        }

        return response()->json($result);
    }

    public function filter(Request $request)
    {
        $kabupatenId = $request->input('kabupaten_id');
        $kecamatanId = $request->input('kecamatan_id');
        $kelurahanId = $request->input('kelurahan_id');
        $rw = $request->input('rw');
        $jenisPemilu = $request->input('jenis_pemilu');

        $subQuery = Vote::select(
            'polling_places.kelurahan_id',
            'polling_places.rw',
            'polling_places.latitude',
            'polling_places.longitude',
            DB::raw('SUM(votes.vote_count) as total_vote_per_tps')
        )
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->groupBy('polling_places.kelurahan_id', 'polling_places.rw', 'polling_places.latitude', 'polling_places.longitude')
            ->orderBy('total_vote_per_tps', 'desc');

        $votes = Vote::select(
            'kelurahans.name as kelurahan_name',
            'kecamatans.name as kecamatan_name',
            'kabupatens.name as kabupaten_name',
            'provinsis.name as provinsi_name',
            'top_tps.latitude',
            'top_tps.longitude',
            DB::raw('SUM(polling_places.DPT) as total_dpt'), // Total DPT per RW
            'polling_places.rw',
            'partais.name as partai_name',
            'partais.color as partai_color',
            DB::raw('SUM(votes.vote_count) as total_vote_per_partai'),
            DB::raw('(SUM(votes.vote_count) / SUM(polling_places.DPT)) * 100 as vote_percentage') // Persentase suara
        )
            ->join('candidates', 'votes.candidate_id', '=', 'candidates.id')
            ->join('partais', 'candidates.partai_id', '=', 'partais.id')
            ->join('polling_places', 'votes.polling_place_id', '=', 'polling_places.id')
            ->join('kelurahans', 'polling_places.kelurahan_id', '=', 'kelurahans.id')
            ->join('kecamatans', 'polling_places.kecamatan_id', '=', 'kecamatans.id')
            ->join('kabupatens', 'polling_places.kabupaten_id', '=', 'kabupatens.id')
            ->join('provinsis', 'polling_places.provinsi_id', '=', 'provinsis.id')
            ->joinSub($subQuery, 'top_tps', function ($join) {
                $join->on('polling_places.kelurahan_id', '=', 'top_tps.kelurahan_id')
                    ->on('polling_places.rw', '=', 'top_tps.rw'); // Gabungkan berdasarkan RW
            })
            ->groupBy(
                'kelurahans.name',
                'kecamatans.name',
                'kabupaten_name',
                'provinsis.name',
                'top_tps.latitude',
                'top_tps.longitude',
                'polling_places.rw',
                'partais.name',
                'partais.color'
            );

        if ($kabupatenId) {
            $votes->where('polling_places.kabupaten_id', $kabupatenId);
        }
        if ($kecamatanId) {
            $votes->where('polling_places.kecamatan_id', $kecamatanId);
        }
        if ($kelurahanId) {
            $votes->where('polling_places.kelurahan_id', $kelurahanId);
        }
        if ($rw) {
            $votes->where('polling_places.rw', $rw);
        }
        if ($jenisPemilu) {
            $votes->where('votes.jenis_pemilu', $jenisPemilu);
        }

        $votes = $votes->get();

        $groupedVotes = $votes->groupBy(function ($item) {
            return $item->kelurahan_name . '_' . $item->kecamatan_name . '_' . $item->kabupaten_name . '_' . $item->provinsi_name . '_' . $item->rw . '_' . $item->latitude . '_' . $item->longitude;
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
                    'total_votes' => $vote->total_vote_per_partai,
                    'vote_percentage' => round($vote->vote_percentage, 2) // Persentase suara dibulatkan ke 2 desimal
                ];
            }
            usort($parties, function ($a, $b) {
                return $b['total_votes'] <=> $a['total_votes'];
            });

            $result[] = [
                'kelurahan_name' => $firstItem->kelurahan_name,
                'kecamatan_name' => $firstItem->kecamatan_name,
                'kabupaten_name' => $firstItem->kabupaten_name,
                'provinsi_name' => $firstItem->provinsi_name,
                'rw' => $firstItem->rw,
                'latitude' => $firstItem->latitude,
                'longitude' => $firstItem->longitude,
                'total_dpt' => $firstItem->total_dpt,  // Mengambil total DPT per RW
                'parties' => $parties
            ];
        }

        return response()->json($result);
    }


    public function map()
    {
        return view('map');
    }

    public function getcolor()
    {
        // $data = Partai::select('name', 'color')->get();
        // return response()->json($data);
        $data = Partai::whereHas('candidate.vote')
                  ->select('name', 'color')
                  ->get();

        return response()->json($data);
    }
}
