<?php

namespace App\Http\Controllers;

use App\Models\Map;
use Illuminate\Http\Request;
use App\Models\Vote;

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

    public function filter(Request $request)
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
        ->join('kelurahans', 'polling_places.kelurahan_id', '=', 'kelurahans.id');
    
        // Filter berdasarkan jenis pemilu (election type)
        if ($request->has('election_type')) {
            $votes->where('elections.name', $request->input('election_type'));
        }
    
        // Filter berdasarkan wilayah (provinsi, kabupaten, kecamatan, kelurahan)
        if ($request->has('provinsi')) {
            $votes->where('provinsis.name', $request->input('provinsi'));
        }
        if ($request->has('kabupaten')) {
            $votes->where('kabupatens.name', $request->input('kabupaten'));
        }
        if ($request->has('kecamatan')) {
            $votes->where('kecamatans.name', $request->input('kecamatan'));
        }
        if ($request->has('kelurahan')) {
            $votes->where('kelurahans.name', $request->input('kelurahan'));
        }
    
        // Filter berdasarkan TPS yang terdaftar di kelurahan
        if ($request->has('polling_place')) {
            $votes->where('polling_places.name', $request->input('polling_place'));
        }
    
        // Eksekusi query dan ambil hasil
        $votes = $votes->get();
    
        return response()->json($votes);
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
