<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kabupaten;
use App\Models\Provinsi;
use App\Models\Kecamatan;
use App\Models\Kelurahan;

class WilayahController extends Controller
{
    public function index_provinsi(Request $request)
    {
        $limit = 10;
        $data = Provinsi::query();
        if ($request->filled('limit') && is_numeric($request->limit)) {
            $limit = intval($request->limit);
        }
        if ($request->filled('type')) {
            $data->where('type', $request->type);
        }
        if ($request->filled('name')) {
            $data->where('name', 'like', "%$request->name%");
        }
        if ($request->filled('code')) {
            $data->where('code', $request->code);
        }
        $result = $data->paginate($limit);
        return response()->json($result);
    }

    public function show_provinsi($id)
    {
        $provinsi = Provinsi::find($id);
        if (!$provinsi) {
            return response()->json(['data' => null, 'message' => 'Not Found!']);
        }
        return response()->json(['data' => $provinsi, 'message' => 'success']);
    }

    public function index_kabupaten(Request $request)
    {
        $limit = 10;
        $data = Kabupaten::query();
        if ($request->filled('limit') && is_numeric($request->limit)) {
            $limit = intval($request->limit);
        }
        if ($request->filled('type')) {
            $data->where('type', $request->type);
        }
        if ($request->filled('name')) {
            $data->where('name', 'like', "%$request->name%");
        }
        if ($request->filled('code')) {
            $data->where('code', $request->code);
        }
        if ($request->filled('full_code')) {
            $data->where('full_code', $request->full_code);
        }
        if ($request->filled('provinsi_id')) {
            $data->where('provinsi_id', $request->provinsi_id);
        }
        if ($request->filled('code_provinsi')) {
            $data->whereRelation('provinsi', 'code', $request->code_provinsi);
        }
        $result = $data->with('provinsi')->withCount('kecamatan')->paginate($limit);
        return response()->json($result);
    }

    public function show_kabupaten(int $id)
    {
        $kabupaten = Kabupaten::find($id);
        if (!$kabupaten) {
            return response()->json(['data' => null, 'message' => 'Not Found!'], 404);
        }
        $kabupaten->load('provinsi');
        return response()->json(['data' => $kabupaten, 'message' => 'success']);
    }

    public function index_kecamatan(Request $request)
    {
        $limit = 10;
        $data = Kecamatan::query();
        if ($request->filled('limit') && is_numeric($request->limit)) {
            $limit = intval($request->limit);
        }
        if ($request->filled('name')) {
            $data->where('name', 'like', "%$request->name%");
        }
        if ($request->filled('code')) {
            $data->where('code', $request->code);
        }
        if ($request->filled('full_code')) {
            $data->where('full_code', $request->full_code);
        }
        if ($request->filled('kabupaten_id')) {
            $data->where('kabupaten_id', $request->kabupaten_id);
        }
        if ($request->filled('code_kabupaten')) {
            $data->whereRelation('kabupaten', 'code', $request->code_kabupaten);
        }
        if ($request->filled('provinsi_id')) {
            $data->whereRelation('kabupaten', 'provinsi_id', $request->provinsi_id);
        }
        if ($request->filled('code_provinsi')) {
            $data->whereRelation('kabupaten.provinsi', 'code', $request->code_provinsi);
        }
        $result = $data->with('kabupaten.provinsi')->paginate($limit);
        return response()->json($result);
    }

    public function show_kecamatan($id)
    {
        $kecamatan = Kecamatan::find($id);
        if (!$kecamatan) {
            return response()->json(['data' => null, 'message' => 'Not Found!'], 404);
        }
        $kecamatan->load('kabupaten.provinsi');
        return response()->json(['data' => $kecamatan, 'message' => 'success']);
    }

    public function index_kelurahan(Request $request)
    {
        $limit = 10;
        $data = Kelurahan::query();
        if ($request->filled('limit') && is_numeric($request->limit)) {
            $limit = intval($request->limit);
        }
        if ($request->filled('name')) {
            $data->where('name', 'like', "%$request->name%");
        }
        if ($request->filled('code')) {
            $data->where('code', $request->code);
        }
        if ($request->filled('full_code')) {
            $data->where('full_code', $request->full_code);
        }
        if ($request->filled('pos_code')) {
            $data->where('pos_code', $request->pos_code);
        }
        if ($request->filled('kecamatan_id')) {
            $data->where('kecamatan_id', $request->kecamatan_id);
        }
        if ($request->filled('code_kecamatan')) {
            $data->whereRelation('kecamatan', 'code', $request->code_kecamatan);
        }
        if ($request->filled('kabupaten_id')) {
            $data->whereRelation('kecamatan', 'kabupaten_id', $request->kabupaten_id);
        }
        if ($request->filled('code_kabupaten')) {
            $data->whereRelation('kecamatan.kabupaten', 'code', $request->code_kabupaten);
        }
        if ($request->filled('provinsi_id')) {
            $data->whereRelation('kecamatan.kabupaten', 'provinsi_id', $request->provinsi_id);
        }
        if ($request->filled('code_provinsi')) {
            $data->whereRelation('kecamatan.kabupaten.provinsi', 'code', $request->code_provinsi);
        }
        $result = $data->with('kecamatan.kabupaten.provinsi')->paginate($limit);
        return response()->json($result);
    }

    public function show_kelurahan($id)
    {
        $kelurahan = Kelurahan::find($id);
        if (!$kelurahan) {
            return response()->json(['data' => null, 'message' => 'Not Found!'], 404);
        }
        $kelurahan->load('kecamatan.kabupaten.provinsi');
        return response()->json(['data' => $kelurahan, 'message' => 'success']);
    }

    public function map()
    {
        $title = 'msp';
        return view('map',compact('title'));
    }
}
