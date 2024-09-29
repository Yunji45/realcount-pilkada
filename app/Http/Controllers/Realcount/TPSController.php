<?php

namespace App\Http\Controllers\Realcount;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\PollingPlace;
use App\Models\Provinsi;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class TPSController extends Controller
{
    public function index(Request $request)
    {
        $length = $request->input('length', 10);
        if ($length <= 0) {
            $length = 10;
        }
        $page = ($request->start / $length) + 1;
        $tps = PollingPlace::with(['kecamatan', 'kelurahan'])
            ->select('polling_places.*', 'dpt', 'rw', 'latitude', 'longitude', 'periode', 'status')
            ->where('status','Aktif')
            ->paginate($length, ['*'], 'page', $page);
        if ($request->ajax()) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $tps->total(),
                'recordsFiltered' => $tps->total(),
                'data' => $tps->items(),
            ]);
        }
        $title = 'TPS Realcount';
        return view('dashboard.admin.realcount.tps', compact('tps', 'title'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'required|string|max:255',
                'provinsi_id' => 'required|exists:provinsis,id',  // Validasi bahwa provinsi_id ada di tabel provinsi
                'kabupaten_id' => 'required|exists:kabupatens,id', // Validasi bahwa kabupaten_id ada di tabel kabupaten
                'kecamatan_id' => 'required|exists:kecamatans,id', // Validasi bahwa kecamatan_id ada di tabel kecamatan
                'kelurahan_id' => 'required|exists:kelurahans,id', // Validasi bahwa kelurahan_id ada di tabel kelurahan
                'rw' => 'required|string|max:255',
                'DPT' => 'required',
                'periode' => 'required'
            ]);
            $tps = PollingPlace::create([
                'name' => $request->name,
                'provinsi_id' => $request->provinsi_id,
                'kabupaten_id' => $request->kabupaten_id,
                'kecamatan_id' => $request->kecamatan_id,
                'kelurahan_id' => $request->kelurahan_id,
                'rw' => $request->rw,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'status' => 'Aktif',
                'longitude' => $request->longitude,
                'latitude' => $request->latitude,
                'DPT' => $request->DPT,
                'periode' => $request->periode
            ]);

            // Commit transaksi jika berhasil
            // dd($tps);
            DB::commit();

            // Redirect ke halaman index dengan pesan sukses
            return redirect()->route('tps.index')
                ->with('success', 'Polling place created successfully.');
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Polling place created successfully.',
            //     'data' => $tps
            // ], 201); // 201 = Created

        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Error creating polling place: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to create polling place. Error: ' . $e->getMessage());
        }
    }

    public function edit(PollingPlace $tp)
    {
        $title = 'Edit TPS';
        $type = 'TPS';
        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::where('provinsi_id', $tp->provinsi_id)->get();
        $kecamatan = Kecamatan::where('kabupaten_id', $tp->kabupaten_id)->get();
        $kelurahan = Kelurahan::where('kecamatan_id', $tp->kecamatan_id)->get();

        return view('dashboard.admin.realcount.edit', compact('tp', 'title', 'type', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'));
    }
    public function update(Request $request, PollingPlace $tp)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'name' => 'sometimes|required|string|max:255',
                'provinsi_id' => 'sometimes|required|exists:provinsis,id',  // Validasi bahwa provinsi_id ada di tabel provinsi
                'kabupaten_id' => 'sometimes|required|exists:kabupatens,id', // Validasi bahwa kabupaten_id ada di tabel kabupaten
                'kecamatan_id' => 'sometimes|required|exists:kecamatans,id', // Validasi bahwa kecamatan_id ada di tabel kecamatan
                'kelurahan_id' => 'sometimes|required|exists:kelurahans,id', // Validasi bahwa kelurahan_id ada di tabel kelurahan
                'rw' => 'sometimes|required|string|max:255',
                'start_date' => 'sometimes|required|date|before_or_equal:end_date', // Pastikan tanggal mulai <= tanggal selesai
                'end_date' => 'sometimes|nullable|date|after_or_equal:start_date',
                'start_time' => 'sometimes|nullable|date_format:H:i',
                'end_time' => 'sometimes|required|date_format:H:i|after:start_time', // Jam tutup harus setelah jam buka
                'status' => 'sometimes|required|in:Aktif,Non-aktif',
            ]);

            $data = $request->only([
                'name',
                'provinsi_id',
                'kabupaten_id',
                'kecamatan_id',
                'kelurahan_id',
                'rw',
                'start_date',
                'end_date',
                'start_time',
                'end_time',
                'status',
            ]);

            $tp->update(array_filter($data));
            DB::commit();
            return redirect()->route('tps.show', $tp->id)
                ->with('success', 'Polling place updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            dd('Error updating polling place: ' . $e->getMessage());
            return redirect()->back()->with('error', 'Failed to update polling place. Please try again.');
        }
    }
}
