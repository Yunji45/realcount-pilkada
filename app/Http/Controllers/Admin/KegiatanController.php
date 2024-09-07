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
        DB::beginTransaction();
        try {
            // Validasi data input
            $validated = $request->validate([
                'nama_kegiatan' => 'sometimes|required|string|max:255',
                'waktu' => 'sometimes|required|date',
                'deskripsi' => 'sometimes|nullable|string',
                'photo' => 'sometimes|nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
                'longitude' => 'sometimes|nullable|numeric',
                'latitude' => 'sometimes|nullable|numeric',
            ]);

            $data = $request->only([
                'nama_kegiatan',
                'waktu',
                'deskripsi',
                'longitude',
                'latitude',
            ]);
            $photoPath = $kegiatan->photo;
            if ($request->hasFile('photo')) {
                if ($kegiatan->photo) {
                    Storage::disk('public')->delete($kegiatan->photo);
                }
                $photoPath = $request->file('photo')->store('kegiatan', 'public');
                $data['photo'] = $photoPath;
            }
            $kegiatan->update(array_filter($data));
            DB::commit();
            return redirect('/kegiatan')->with('success', 'Kegiatan berhasil diperbarui.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Gagal memperbarui kegiatan. Pesan error: ' . $th->getMessage());
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
