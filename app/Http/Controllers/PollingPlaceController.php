<?php

namespace App\Http\Controllers;

use App\Models\PollingPlace;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class PollingPlaceController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Mengambil semua TPS dan mengembalikannya ke tampilan
        $pollingPlaces = PollingPlace::all();
        return view('polling_places.index', compact('pollingPlaces'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Menampilkan form untuk membuat TPS baru
        return view('polling_places.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input dari form
        $request->validate([
            'nama_tps' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:100',
            'desa_kelurahan' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        DB::beginTransaction();
        try {
            // Menyimpan TPS baru ke database
            PollingPlace::create($request->all());

            // Redirect ke halaman index dengan pesan sukses

            DB::commit();
            return redirect()->route('polling_places.index')
                ->with('success', 'Polling place created successfully.');
        } catch (\Exception $e) {

            DB::rollBack();
            // Menangani kesalahan dan mengarahkan kembali dengan pesan error
            return redirect()->back()->with('error', 'Failed to create polling place. Please try again.');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(PollingPlace $pollingPlace)
    {
        // Menampilkan detail TPS
        return view('polling_places.show', compact('pollingPlace'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(PollingPlace $pollingPlace)
    {
        // Menampilkan form untuk mengedit TPS
        return view('polling_places.edit', compact('pollingPlace'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, PollingPlace $pollingPlace)
    {
        // Validasi input dari form
        $request->validate([
            'nama_tps' => 'required|string|max:255',
            'alamat' => 'required|string',
            'kecamatan' => 'required|string|max:100',
            'desa_kelurahan' => 'required|string|max:100',
            'tanggal_mulai' => 'required|date',
            'tanggal_selesai' => 'required|date',
            'jam_buka' => 'required|date_format:H:i',
            'jam_tutup' => 'required|date_format:H:i',
            'status' => 'required|in:aktif,non-aktif',
        ]);

        DB::beginTransaction();
        try {
            // Mengupdate TPS di database
            $pollingPlace->update($request->all());

            // Redirect ke halaman detail TPS dengan pesan sukses

            DB::commit();
            return redirect()->route('polling_places.show', $pollingPlace->id)
                ->with('success', 'Polling place updated successfully.');
        } catch (\Exception $e) {
            // Menangani kesalahan dan mengarahkan kembali dengan pesan error
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to update polling place. Please try again.');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(PollingPlace $pollingPlace)
    {
        DB::beginTransaction();
        try {
            // Menghapus TPS dari database
            $pollingPlace->delete();

            // Redirect ke halaman index dengan pesan sukses

            DB::commit();
            return redirect()->route('polling_places.index')
                ->with('success', 'Polling place deleted successfully.');
        } catch (\Exception $e) {
            // Menangani kesalahan dan mengarahkan kembali dengan pesan error
            DB::rollBack();
            return redirect()->back()->with('error', 'Failed to delete polling place. Please try again.');
        }
    }
}
