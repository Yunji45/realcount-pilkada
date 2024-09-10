<?php

namespace App\Http\Controllers;

use App\Models\Partai;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class PartaiController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $partais = Partai::all();
        $title = "Partai";

        return view('dashboard.admin.partai.index', compact('partais', 'title'));
        // return $partais;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Partai";
        $type = "Tambah Data";

        return view('dashboard.admin.partai.create', compact('title', 'type'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'color' => ['required', 'string', 'max:255'],
                'leader' => ['required', 'string', 'max:255'],
                'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],  // Optional logo
            ]);

            if ($request->hasFile('logo')) {
                // Ambil nama asli dari file logo
                $originalName = $request->file('logo')->getClientOriginalName();

                // Tambahkan timestamp untuk menghindari nama file yang sama
                $filename = time() . '_' . $originalName;

                // Simpan file logo ke folder 'file/partai' di storage dengan nama file asli
                $logoPath = $request->file('logo')->storeAs('file/partai', $filename, 'public');

                // Simpan path logo ke dalam array yang akan divalidasi atau disimpan ke database
                $validated['logo'] = $logoPath;
            }


            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $partai = Partai::create([
                'name' => $request->name,
                'color' => $request->color,
                'leader' => $request->leader,
                'logo' => $logoPath,
            ]);

            DB::commit();

            return redirect()->route('partai.index')->with('success', 'Partai created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            dd($th->getMessage());
            return back()->with('error', 'Partai creation failed')->withInput();
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Partai $partai)
    {
        return view('partais.show', compact('partai'));
        // return $partai;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Partai $partai)
    {
        $title = "Partai";
        $type = "Edit Data";

        return view('dashboard.admin.partai.edit', compact('partai', 'title', 'type'));
        // return $partai;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Partai $partai)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'color' => ['required', 'string', 'max:255'],
                'leader' => ['required', 'string', 'max:255'],
                'logo' => ['nullable', 'image', 'mimes:jpeg,png,jpg,gif', 'max:2048'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $file = $request->file('logo');
            $path = $partai->logo;

            if ($file && $file->isValid()) {
                // Ambil nama asli dari file logo
                $originalName = $request->file('logo')->getClientOriginalName();

                // Tambahkan timestamp untuk menghindari nama file yang sama
                $filename = time() . '_' . $originalName;

                // Simpan file logo ke folder 'file/partai' di storage dengan nama file asli
                $path = $file->store('file/partai', $filename, 'public');

                // Cek file logo jika ada maka hapus foto terdahulu
                if ($partai->logo && Storage::disk('public')->exists($partai->logo)) {
                    Storage::disk('public')->delete($partai->logo);
                }
            }

            $partai->update([
                'name' => $request->name,
                'color' => $request->color,
                'leader' => $request->leader,
                'logo' => $path,
            ]);

            DB::commit();

            return redirect()->route('partai.index')->with('success', 'Partai updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Partai update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Partai $partai)
    {
        DB::beginTransaction();
        try {
            $partai->delete();

            DB::commit();

            return redirect()->route('partai.index')->with('success', 'Partai deleted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', 'Partai deletion failed. The partai is still referenced in another table.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'An unexpected error occurred.');
        }
    }
}
