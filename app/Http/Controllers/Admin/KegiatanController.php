<?php

namespace App\Http\Controllers\Admin;

use App\Models\Kegiatan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Http\Controllers\Controller;


class KegiatanController extends Controller
{
    // Get all Kegiatan
    public function index()
    {
        $title = 'Kegiatan';
        $type = 'AKtivitas';
        $kegiatans= Kegiatan::all();
        return view('dashboard.admin.kegiatan.index', compact('kegiatans', 'title', 'type'));
    }

    public function edit($id)
    {
        $title = 'Kegiatan';
        $type = 'AKtivitas';
        $kegiatan = Kegiatan::find($id);
        // return $kegiatan;
        return view('dashboard.admin.kegiatan.create', compact('title', 'type','kegiatan'));   
    }

    public function create()
    {
        $title = 'Kegiatan';
        $type = 'AKtivitas';
        return view('dashboard.admin.kegiatan.create', compact('title', 'type'));   
    }
    // Store new Kegiatan
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validated = $request->validate([
                'nama_kegiatan' => 'nullable|string|max:255',
                'waktu' => 'nullable|date',
                'deskripsi' => 'nullable|string',
                'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            ]);

            if ($request->hasFile('photo')) {
                $photoPath = $request->file('photo')->store('kegiatan', 'public');
                $validated['photo'] = $photoPath;
            }

            // $kegiatan = Kegiatan::create($validated);
            $kegiatan = Kegiatan::create([
                'user_id' => Auth::user()->id,
                'nama_kegiatan' => $request->nama_kegiatan,
                'waktu' => $request->waktu,
                'deskripsi' => $request->deskripsi,
                'photo' => $photoPath,
                'longitude' => null,
                'latitude' => null,
            ]);
            DB::commit();
            return redirect('/kegiatan')->with('success', 'Kegiatan created successfully');
        } catch (Exception $e) {
            return back()->with(['error' => 'User creation failed.']);
        }
    }

    // Show single Kegiatan
    public function show($id)
    {
        try {
            $kegiatan = Kegiatan::findOrFail($id);
            return response()->json(['kegiatan' => $kegiatan], 200);
        } catch (Exception $e) {
            return response()->json(['error' => 'Failed to retrieve Kegiatan', 'message' => $e->getMessage()], 404);
        }
    }

    // Update Kegiatan
    public function update(Request $request, Kegiatan $kegiatan)
    {
        $validated = $request->validate([
            'nama_kegiatan' => 'required|string|max:255',
            'waktu' => 'required|date',
            'deskripsi' => 'nullable|string',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'longitude' => 'nullable|numeric',
            'latitude' => 'nullable|numeric',
        ]);
    
        DB::beginTransaction();
        try {
            $photoPath = $kegiatan->photo; // Inisialisasi dengan photo lama
    
            if ($request->hasFile('photo')) {
                // Hapus photo lama jika ada
                if ($kegiatan->photo) {
                    Storage::disk('public')->delete($kegiatan->photo);
                }
                // Simpan photo baru
                $photoPath = $request->file('photo')->store('kegiatan', 'public');
            }
    
            $kegiatan->update([
                'user_id' => Auth::user()->id,
                'nama_kegiatan' => $validated['nama_kegiatan'],
                'waktu' => $validated['waktu'],
                'deskripsi' => $validated['deskripsi'] ?? null,
                'photo' => $photoPath,
                'longitude' => $validated['longitude'] ?? null,
                'latitude' => $validated['latitude'] ?? null,
            ]);
    
            DB::commit();
            return redirect('/kegiatan')->with('success', 'Kegiatan updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Kegiatan update failed. ' . $th->getMessage());
        }
    }
    
    // Delete Kegiatan
    public function destroy($id)
    {
        try {
            $kegiatan = Kegiatan::findOrFail($id);

            if ($kegiatan->photo) {
                Storage::disk('public')->delete($kegiatan->photo);
            }

            $kegiatan->delete();
            return redirect('/kegiatan')->with('success', 'Kegiatan Deleted successfully');
        } catch (Exception $e) {
            return back()->with(['error' => 'Kegiatan Deleted failed.']);
            // return response()->json(['error' => 'Failed to delete Kegiatan', 'message' => $e->getMessage()], 500);
        }
    }
}
