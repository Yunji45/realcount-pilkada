<?php

namespace App\Http\Controllers;

// use App\Imports\PollingPlaceImport;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use App\Models\PollingPlace;
use App\Models\Provinsi;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
// use Maatwebsite\Excel\Facades\Excel;

class PollingPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $length = $request->input('length', 10); // Default to 10 if no length provided
        if ($length <= 0) {
            $length = 10; // Set to 10 if length is zero or negative
        }

        $page = ($request->start / $length) + 1;

        $tps = PollingPlace::with(['kecamatan', 'kelurahan'])
            ->select('polling_places.*', 'dpt', 'rw', 'latitude', 'longitude', 'periode', 'status') // Ensure required fields are selected
            ->paginate($length, ['*'], 'page', $page);

        if ($request->ajax()) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $tps->total(),
                'recordsFiltered' => $tps->total(),
                'data' => $tps->items(),
            ]);
        }

        $title = 'TPS';
        return view('dashboard.admin.polling-places.index', compact('tps', 'title'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $provinsi = Provinsi::all();  // Hanya ambil data Provinsi di awal
        $title = 'TPS';
        $type = 'Create';

        return view('dashboard.admin.polling-places.create', compact('provinsi', 'title', 'type'));
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

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validasi input dari form
            $request->validate([
                'name' => 'required|string|max:255',
                'provinsi_id' => 'required|exists:provinsis,id',  // Validasi bahwa provinsi_id ada di tabel provinsi
                'kabupaten_id' => 'required|exists:kabupatens,id', // Validasi bahwa kabupaten_id ada di tabel kabupaten
                'kecamatan_id' => 'required|exists:kecamatans,id', // Validasi bahwa kecamatan_id ada di tabel kecamatan
                'kelurahan_id' => 'required|exists:kelurahans,id', // Validasi bahwa kelurahan_id ada di tabel kelurahan
                'rw' => 'required|string|max:255',
                'status' => 'required|in:Aktif,Non-aktif',
                'DPT' => 'required',
                'periode' => 'required'
            ]);

            // Menyimpan TPS baru ke database
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
                'status' => $request->status,
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

            // Logging error untuk debugging (optional)
            Log::error('Error creating polling place: ' . $e->getMessage());

            // Menangani kesalahan dan mengarahkan kembali dengan pesan error
            return redirect()->back()->with('error', 'Failed to create polling place. Error: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(PollingPlace $tp)
    {
        // Menampilkan detail TPS
        return view('dashboard.admin.polling-places.show', compact('tp'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PollingPlace $tp)
    {
        $title = 'TPS';
        $type = 'Edit';

        // Ambil data provinsi, kabupaten, kecamatan, dan kelurahan
        $provinsi = Provinsi::all();
        $kabupaten = Kabupaten::where('provinsi_id', $tp->provinsi_id)->get();
        $kecamatan = Kecamatan::where('kabupaten_id', $tp->kabupaten_id)->get();
        $kelurahan = Kelurahan::where('kecamatan_id', $tp->kecamatan_id)->get();

        // Menampilkan form untuk mengedit TPS
        return view('dashboard.admin.polling-places.edit', compact('tp', 'title', 'type', 'provinsi', 'kabupaten', 'kecamatan', 'kelurahan'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PollingPlace $tp)
    {
        DB::beginTransaction();
        try {
            // Validasi input dari form
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

            // Update TPS yang ada di database
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

            // Hanya update field yang ada di request
            $tp->update(array_filter($data));

            // Commit transaksi jika berhasil
            DB::commit();

            // Redirect ke halaman detail TPS dengan pesan sukses
            return redirect()->route('tps.show', $tp->id)
                ->with('success', 'Polling place updated successfully.');
        } catch (\Exception $e) {
            DB::rollBack();

            // Logging error untuk debugging (optional)
            dd('Error updating polling place: ' . $e->getMessage());

            // Menangani kesalahan dan mengarahkan kembali dengan pesan error
            return redirect()->back()->with('error', 'Failed to update polling place. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(PollingPlace $tp)
    {
        DB::beginTransaction();
        try {
            // Hapus partai
            $tp->delete();

            DB::commit();

            return redirect()->route('polling_places.index')
                ->with('success', 'Party deleted successfully.');
        } catch (QueryException $e) {
            // Rollback jika terjadi error terkait basis data
            DB::rollBack();
            return redirect()->back()->with('error', 'Cannot delete this party because it is being used in other records.');
        } catch (\Exception $e) {
            // Rollback jika terjadi kesalahan umum
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete party. Please try again.');
        }
    }

    public function massDelete(Request $request)
    {
        $ids = $request->selected_ids;

        if ($ids) {
            try {
                PollingPlace::whereIn('id', $ids)->delete();
                return response()->json(['message' => 'Selected TPS deleted successfully.']);
            } catch (\Illuminate\Database\QueryException $e) {
                if ($e->getCode() == 23000) { // Integrity constraint violation
                    return response()->json([
                        'message' => 'Some TPS cannot be deleted because they are associated with other records.'
                    ], 400);
                }
                return response()->json(['message' => 'An unexpected error occurred.'], 500);
            }
        }

        return response()->json(['message' => 'No TPS selected for deletion.'], 400);
    }


    // public function import()
    // {
    //     try {
    //         Excel::import(new PollingPlaceImport, request()->file('your_file'));

    //         return redirect()->route("tps.index")->with('success', 'TPS Berhasil Di Import!');
    //     } catch (\Throwable $th) {
    //         return back()->with("error", $th->getMessage());
    //     }
    // }

}
