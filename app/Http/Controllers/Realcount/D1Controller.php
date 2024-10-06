<?php

namespace App\Http\Controllers\Realcount;

use App\Http\Controllers\Controller;
use App\Models\Filed1;
use App\Models\Provinsi;
use App\Models\TpsRealcount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class D1Controller extends Controller
{
    public function index(Request $request)
    {
        $title = 'File D1';
        $length = $request->input('length', 10);
        if ($length <= 0) {
            $length = 10;
        }
        $page = ($request->start / $length) + 1;
        $votes = Filed1::with('kecamatan')
            ->paginate($length, ['*'], 'page', $page);
        $data = $votes->items();
            foreach ($data as $vote) {
                $vote->file = Storage::url($vote->file);
            }
        if ($request->ajax()) {
            return response()->json([
                'draw' => intval($request->draw),
                'recordsTotal' => $votes->total(),
                'recordsFiltered' => $votes->total(),
                'data' => $votes->items()
            ]);
        }
        return view('dashboard.admin.realcount.d1.index', compact('title'));
    }

    public function create()
    {
        $title = 'File D1';
        $type = 'Tambah';
        $pollingPlaces = TpsRealcount::all();
        $provinsis = Provinsi::all();
        return view('dashboard.admin.realcount.d1.create', compact('title', 'type', 'pollingPlaces', 'provinsis'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'kecamatan_id' => 'required|exists:kecamatans,id',
                'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            ]);
            Log::info('Validasi berhasil.', ['kecamatan_id' => $request->kecamatan_id]);

            $fileExists = Filed1::where('kecamatan_id', $request->kecamatan_id)->exists();
            if ($fileExists) {
                Log::info('File D1 untuk kecamatan ini sudah diupload.', ['kecamatan_id' => $request->kecamatan_id]);
                return redirect()->back()->with('info', 'File D1 untuk kecamatan ini sudah diupload.');
            }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('File_D1', 'public');
                Log::info('File berhasil disimpan.', ['path' => $path]);

                Filed1::create([
                    'kecamatan_id' => $request->kecamatan_id,
                    'file' => $path
                ]);
                DB::commit();
                Log::info('File D1 berhasil diupload.', ['kecamatan_id' => $request->kecamatan_id]);
                return redirect()->route('file-d1.index')->with('success', 'File D1 berhasil diupload.');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal mengupload file.', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Gagal mengupload file.');
        }
    }

    public function show($id) {}

    public function edit($id) {}

    public function update(Request $request, $id) {}

    public function destroy($file_d1)
    {
        DB::beginTransaction();
        try {
            $filed1 = Filed1::findOrFail($file_d1);
            if (Storage::disk('public')->exists($filed1->file)) {
                Storage::disk('public')->delete($filed1->file);
                Log::info('File berhasil dihapus dari storage.', ['path' => $filed1->file]);
            } else {
                Log::warning('File tidak ditemukan di storage.', ['path' => $filed1->file]);
            }
            $filed1->delete();
            DB::commit();

            Log::info('File D1 berhasil dihapus.', ['id' => $file_d1]);
            return redirect()->route('file-D1.index')->with('success', 'File D1 berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal menghapus file.', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menghapus file.');
        }
    }
}
