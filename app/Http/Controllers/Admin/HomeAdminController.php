<?php

namespace App\Http\Controllers\Admin;

use App\Charts\VotePerorangChart;
use App\Charts\VotePartaiChart;
use App\Charts\VotePerPollingPlaceChart;
use App\Http\Controllers\Controller;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    public function index(Request $request, VotePerorangChart $votePerorang, VotePartaiChart $votePartai, VotePerPollingPlaceChart $votePerTps)
    {
        $provinsis = Provinsi::all();

        $filter = [
            'provinsi_id' => $request->input('provinsi_id'),
            'kabupaten_id' => $request->input('kabupaten_id'),
            'kecamatan_id' => $request->input('kecamatan_id'),
            'kelurahan_id' => $request->input('kelurahan_id')
        ];

        // Return view with initial data and chart
        return view('dashboard.admin.dashboard.index', [
            'votePerorang' => $votePerorang->build(),
            'votePartai' => $votePartai->build(),
            'votePerTps' => $votePerTps->build($filter),
            'provinsis' => $provinsis,
        ]);
    }

    // Method untuk mendapatkan Kabupaten berdasarkan Provinsi
    public function getKabupaten($provinsiId)
    {
        $kabupaten = Kabupaten::where('provinsi_id', $provinsiId)->get();
        return response()->json($kabupaten);
    }

    // Method untuk mendapatkan Kecamatan berdasarkan Kabupaten
    public function getKecamatan($kabupatenId)
    {
        $kecamatan = Kecamatan::where('kabupaten_id', $kabupatenId)->get();
        return response()->json($kecamatan);
    }

    // Method untuk mendapatkan Kelurahan berdasarkan Kecamatan
    public function getKelurahan($kecamatanId)
    {
        $kelurahan = Kelurahan::where('kecamatan_id', $kecamatanId)->get();
        return response()->json($kelurahan);
    }
}
