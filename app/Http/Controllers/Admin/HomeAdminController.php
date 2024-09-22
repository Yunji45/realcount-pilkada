<?php

namespace App\Http\Controllers\Admin;

use App\Charts\VotePerorangChart;
use App\Charts\VotePartaiChart;
use App\Charts\VotePerPollingPlacePartaiChart;
use App\Charts\VotePerPollingPlacePerorangChart;
use App\Http\Controllers\Controller;
use App\Models\Election;
use App\Models\PollingPlace;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Http\Request;

class HomeAdminController extends Controller
{
    public function index(Request $request, VotePerorangChart $votePerorang, VotePartaiChart $votePartai, VotePerPollingPlacePerorangChart $votePerTpsPerorang, VotePerPollingPlacePartaiChart $votePerTpsPartai)
    {
        //Koordinator
        $koordinatorAktif = User::role('Koordinator')
            ->where('status', 'Aktif')
            ->count();
        $koordinatorNonaktif = User::role('Koordinator')
            ->where('status', 'Nonaktif')
            ->count();

        //Pemilih
        $pemilihAktif = User::role('Pemilih')
            ->where('status', 'Aktif')
            ->count();
        $pemilihNonaktif = User::role('Pemilih')
            ->where('status', 'Nonaktif')
            ->count();

        //Saksi
        $saksiAktif = User::role('Saksi')
            ->where('status', 'Aktif')
            ->count();
        $saksiNonaktif = User::role('Saksi')
            ->where('status', 'Nonaktif')
            ->count();

        //Relawan RDW
        $relawanRdwAktif = User::role('Relawan RDW')
            ->where('status', 'Aktif')
            ->count();
        $relawanRdwNonaktif = User::role('Relawan RDW')
            ->where('status', 'Nonaktif')
            ->count();

        //Simpatisan
        $simpatisanAktif = User::role('Simpatisan')
            ->where('status', 'Aktif')
            ->count();
        $simpatisanNonaktif = User::role('Simpatisan')
            ->where('status', 'Nonaktif')
            ->count();

        //Lain-lain
        $lainLainAktif = User::role('Lain-lain')
            ->where('status', 'Aktif')
            ->count();
        $lainLainNonaktif = User::role('Lain-lain')
            ->where('status', 'Nonaktif')
            ->count();

        $provinsis = Provinsi::all();
        $electionsPerorangs = Election::where('type', 'Perorang')
            ->get();
        $electionsPartais = Election::where('type', 'Partai')
            ->get();

        $filter = [
            'provinsi_id' => $request->input('provinsi_id'),
            'kabupaten_id' => $request->input('kabupaten_id'),
            'kecamatan_id' => $request->input('kecamatan_id'),
            'kelurahan_id' => $request->input('kelurahan_id'),
            'election_id' => $request->input('election_id'),
        ];

        $title = 'Dashboard | Admin';

        // Return view with initial data and chart
        return view('dashboard.admin.dashboard.index', [
            'koordinatorAktif' => $koordinatorAktif,
            'koordinatorNonaktif' => $koordinatorNonaktif,
            'pemilihAktif' => $pemilihAktif,
            'pemilihNonaktif' => $pemilihNonaktif,
            'saksiAktif' => $saksiAktif,
            'saksiNonaktif' => $saksiNonaktif,
            'relawanRdwAktif' => $relawanRdwAktif,
            'relawanRdwNonaktif' => $relawanRdwNonaktif,
            'simpatisanAktif' => $simpatisanAktif,
            'simpatisanNonaktif' => $simpatisanNonaktif,
            'lainLainAktif' => $lainLainAktif,
            'lainLainNonaktif' => $lainLainNonaktif,

            'votePerorang' => $votePerorang->build(),
            'votePartai' => $votePartai->build(),
            'votePerTpsPerorang' => $votePerTpsPerorang->build($filter),
            'votePerTpsPartai' => $votePerTpsPartai->build($filter),
            'provinsis' => $provinsis,
            'electionsPerorangs' => $electionsPerorangs,
            'electionsPartais' => $electionsPartais,
            'title' => $title,
        ]);
    }

    public function indexPerorangan(Request $request, VotePerorangChart $votePerorang, VotePartaiChart $votePartai, VotePerPollingPlacePerorangChart $votePerTpsPerorang, VotePerPollingPlacePartaiChart $votePerTpsPartai)
    {
        //Koordinator
        $koordinatorAktif = User::role('Koordinator')
            ->where('status', 'Aktif')
            ->count();
        $koordinatorNonaktif = User::role('Koordinator')
            ->where('status', 'Nonaktif')
            ->count();

        //Pemilih
        $pemilihAktif = User::role('Pemilih')
            ->where('status', 'Aktif')
            ->count();
        $pemilihNonaktif = User::role('Pemilih')
            ->where('status', 'Nonaktif')
            ->count();

        //Saksi
        $saksiAktif = User::role('Saksi')
            ->where('status', 'Aktif')
            ->count();
        $saksiNonaktif = User::role('Saksi')
            ->where('status', 'Nonaktif')
            ->count();

        //Relawan RDW
        $relawanRdwAktif = User::role('Relawan RDW')
            ->where('status', 'Aktif')
            ->count();
        $relawanRdwNonaktif = User::role('Relawan RDW')
            ->where('status', 'Nonaktif')
            ->count();

        //Simpatisan
        $simpatisanAktif = User::role('Simpatisan')
            ->where('status', 'Aktif')
            ->count();
        $simpatisanNonaktif = User::role('Simpatisan')
            ->where('status', 'Nonaktif')
            ->count();

        //Lain-lain
        $lainLainAktif = User::role('Lain-lain')
            ->where('status', 'Aktif')
            ->count();
        $lainLainNonaktif = User::role('Lain-lain')
            ->where('status', 'Nonaktif')
            ->count();

        $provinsis = Provinsi::all();
        $electionsPerorangs = Election::where('type', 'Perorang')
            ->get();
        $electionsPartais = Election::where('type', 'Partai')
            ->get();

        $filter = [
            'provinsi_id' => $request->input('provinsi_id'),
            'kabupaten_id' => $request->input('kabupaten_id'),
            'kecamatan_id' => $request->input('kecamatan_id'),
            'kelurahan_id' => $request->input('kelurahan_id'),
            'rw_id' => $request->input('rw_id'),  // Add RW filter here
            'election_id' => $request->input('election_id'),
        ];

        $title = 'Perorangan';

        // Return view with initial data and chart
        return view('dashboard.admin.dashboard.perorangan', data: [
            'koordinatorAktif' => $koordinatorAktif,
            'koordinatorNonaktif' => $koordinatorNonaktif,
            'pemilihAktif' => $pemilihAktif,
            'pemilihNonaktif' => $pemilihNonaktif,
            'saksiAktif' => $saksiAktif,
            'saksiNonaktif' => $saksiNonaktif,
            'relawanRdwAktif' => $relawanRdwAktif,
            'relawanRdwNonaktif' => $relawanRdwNonaktif,
            'simpatisanAktif' => $simpatisanAktif,
            'simpatisanNonaktif' => $simpatisanNonaktif,
            'lainLainAktif' => $lainLainAktif,
            'lainLainNonaktif' => $lainLainNonaktif,

            'votePerorang' => $votePerorang->build(),
            'votePartai' => $votePartai->build(),
            'votePerTpsPerorang' => $votePerTpsPerorang->build($filter),
            'votePerTpsPartai' => $votePerTpsPartai->build($filter),
            'provinsis' => $provinsis,
            'electionsPerorangs' => $electionsPerorangs,
            'electionsPartais' => $electionsPartais,
            'title' => $title,
        ]);
    }
    public function indexPartai(Request $request, VotePerorangChart $votePerorang, VotePartaiChart $votePartai, VotePerPollingPlacePerorangChart $votePerTpsPerorang, VotePerPollingPlacePartaiChart $votePerTpsPartai)
    {
        //Koordinator
        $koordinatorAktif = User::role('Koordinator')
            ->where('status', 'Aktif')
            ->count();
        $koordinatorNonaktif = User::role('Koordinator')
            ->where('status', 'Nonaktif')
            ->count();

        //Pemilih
        $pemilihAktif = User::role('Pemilih')
            ->where('status', 'Aktif')
            ->count();
        $pemilihNonaktif = User::role('Pemilih')
            ->where('status', 'Nonaktif')
            ->count();

        //Saksi
        $saksiAktif = User::role('Saksi')
            ->where('status', 'Aktif')
            ->count();
        $saksiNonaktif = User::role('Saksi')
            ->where('status', 'Nonaktif')
            ->count();

        //Relawan RDW
        $relawanRdwAktif = User::role('Relawan RDW')
            ->where('status', 'Aktif')
            ->count();
        $relawanRdwNonaktif = User::role('Relawan RDW')
            ->where('status', 'Nonaktif')
            ->count();

        //Simpatisan
        $simpatisanAktif = User::role('Simpatisan')
            ->where('status', 'Aktif')
            ->count();
        $simpatisanNonaktif = User::role('Simpatisan')
            ->where('status', 'Nonaktif')
            ->count();

        //Lain-lain
        $lainLainAktif = User::role('Lain-lain')
            ->where('status', 'Aktif')
            ->count();
        $lainLainNonaktif = User::role('Lain-lain')
            ->where('status', 'Nonaktif')
            ->count();

        $provinsis = Provinsi::all();
        $electionsPerorangs = Election::where('type', 'Perorang')
            ->get();
        $electionsPartais = Election::where('type', 'Partai')
            ->get();

        $filter = [
            'provinsi_id' => $request->input('provinsi_id'),
            'kabupaten_id' => $request->input('kabupaten_id'),
            'kecamatan_id' => $request->input('kecamatan_id'),
            'kelurahan_id' => $request->input('kelurahan_id'),
            'rw_id' => $request->input('rw_id'),  // Tambah RW ID
            'election_id' => $request->input('election_id'),
        ];

        $title = 'Partai';

        return view('dashboard.admin.dashboard.partai', data: [
            'koordinatorAktif' => $koordinatorAktif,
            'koordinatorNonaktif' => $koordinatorNonaktif,
            'pemilihAktif' => $pemilihAktif,
            'pemilihNonaktif' => $pemilihNonaktif,
            'saksiAktif' => $saksiAktif,
            'saksiNonaktif' => $saksiNonaktif,
            'relawanRdwAktif' => $relawanRdwAktif,
            'relawanRdwNonaktif' => $relawanRdwNonaktif,
            'simpatisanAktif' => $simpatisanAktif,
            'simpatisanNonaktif' => $simpatisanNonaktif,
            'lainLainAktif' => $lainLainAktif,
            'lainLainNonaktif' => $lainLainNonaktif,

            'votePerorang' => $votePerorang->build(),
            'votePartai' => $votePartai->build($filter),  // Pass the filter here
            'votePerTpsPerorang' => $votePerTpsPerorang->build($filter),
            'votePerTpsPartai' => $votePerTpsPartai->build($filter),  // Pass the filter here
            'provinsis' => $provinsis,
            'electionsPerorangs' => $electionsPerorangs,
            'electionsPartais' => $electionsPartais,
            'title' => $title
        ]);
    }
    public function indexPeta(Request $request, VotePerorangChart $votePerorang, VotePartaiChart $votePartai, VotePerPollingPlacePerorangChart $votePerTpsPerorang, VotePerPollingPlacePartaiChart $votePerTpsPartai)
    {
        //Koordinator
        $koordinatorAktif = User::role('Koordinator')
            ->where('status', 'Aktif')
            ->count();
        $koordinatorNonaktif = User::role('Koordinator')
            ->where('status', 'Nonaktif')
            ->count();

        //Pemilih
        $pemilihAktif = User::role('Pemilih')
            ->where('status', 'Aktif')
            ->count();
        $pemilihNonaktif = User::role('Pemilih')
            ->where('status', 'Nonaktif')
            ->count();

        //Saksi
        $saksiAktif = User::role('Saksi')
            ->where('status', 'Aktif')
            ->count();
        $saksiNonaktif = User::role('Saksi')
            ->where('status', 'Nonaktif')
            ->count();

        //Relawan RDW
        $relawanRdwAktif = User::role('Relawan RDW')
            ->where('status', 'Aktif')
            ->count();
        $relawanRdwNonaktif = User::role('Relawan RDW')
            ->where('status', 'Nonaktif')
            ->count();

        //Simpatisan
        $simpatisanAktif = User::role('Simpatisan')
            ->where('status', 'Aktif')
            ->count();
        $simpatisanNonaktif = User::role('Simpatisan')
            ->where('status', 'Nonaktif')
            ->count();

        //Lain-lain
        $lainLainAktif = User::role('Lain-lain')
            ->where('status', 'Aktif')
            ->count();
        $lainLainNonaktif = User::role('Lain-lain')
            ->where('status', 'Nonaktif')
            ->count();

        $provinsis = Provinsi::all();
        $electionsPerorangs = Election::where('type', 'Perorang')
            ->get();
        $electionsPartais = Election::where('type', 'Partai')
            ->get();

        $filter = [
            'provinsi_id' => $request->input('provinsi_id'),
            'kabupaten_id' => $request->input('kabupaten_id'),
            'kecamatan_id' => $request->input('kecamatan_id'),
            'kelurahan_id' => $request->input('kelurahan_id'),
            'election_id' => $request->input('election_id'),
        ];

        $title = 'Peta';

        // Return view with initial data and chart
        return view('dashboard.admin.dashboard.peta', [
            'koordinatorAktif' => $koordinatorAktif,
            'koordinatorNonaktif' => $koordinatorNonaktif,
            'pemilihAktif' => $pemilihAktif,
            'pemilihNonaktif' => $pemilihNonaktif,
            'saksiAktif' => $saksiAktif,
            'saksiNonaktif' => $saksiNonaktif,
            'relawanRdwAktif' => $relawanRdwAktif,
            'relawanRdwNonaktif' => $relawanRdwNonaktif,
            'simpatisanAktif' => $simpatisanAktif,
            'simpatisanNonaktif' => $simpatisanNonaktif,
            'lainLainAktif' => $lainLainAktif,
            'lainLainNonaktif' => $lainLainNonaktif,

            'votePerorang' => $votePerorang->build(),
            'votePartai' => $votePartai->build(),
            'votePerTpsPerorang' => $votePerTpsPerorang->build($filter),
            'votePerTpsPartai' => $votePerTpsPartai->build($filter),
            'provinsis' => $provinsis,
            'electionsPerorangs' => $electionsPerorangs,
            'electionsPartais' => $electionsPartais,
            'title' => $title,
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

    public function getRw($kelurahanId)
    {
        $rws = PollingPlace::where('kelurahan_id', $kelurahanId)->select('rw')->distinct()->get();
        return response()->json($rws);
    }

}
