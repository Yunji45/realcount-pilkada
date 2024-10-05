<?php

namespace App\Http\Controllers\Realcount;

use App\Http\Controllers\Controller;
use App\Models\Filec1;
use App\Models\Provinsi;
use App\Models\TpsRealcount;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class C1Controller extends Controller
{
    public function index(Request $request)
    {
        $title = 'File C1';
        $length = max((int) $request->input('length', 10), 1);
        $start = (int) $request->input('start', 0);
        $page = intval($start / $length) + 1;
        $votes = Filec1::with('tpsrealcount.kelurahan', 'tpsrealcount.kecamatan')
            ->paginate($length, ['*'], 'page', $page);
        $data = $votes->items();
        foreach ($data as $vote) {
            $vote->file = Storage::url($vote->file);
        }
        if ($request->ajax()) {
            return response()->json([
                'draw' => intval($request->input('draw', 0)),
                'recordsTotal' => $votes->total(),
                'recordsFiltered' => $votes->total(),
                'data' => $votes->items()
            ]);
        }
        return view('dashboard.admin.realcount.c1.index', compact('title'));
    }

    public function create()
    {
        $title = 'File C1';
        $type = 'Tambah';
        $pollingPlaces = TpsRealcount::all();
        $provinsis = Provinsi::all();
        return view('dashboard.admin.realcount.c1.create', compact('title', 'type', 'pollingPlaces', 'provinsis'));
    }

    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'tps_realcount_id' => 'required|exists:tps_realcounts,id',
                'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            ]);
            Log::info('Validasi berhasil.', ['tps_realcount_id' => $request->tps_realcount_id]);

            $fileExists = Filec1::where('tps_realcount_id', $request->tps_realcount_id)->exists();
            if ($fileExists) {
                Log::info('File C1 untuk polling place ini sudah diupload.', ['tps_realcount_id' => $request->tps_realcount_id]);
                return redirect()->back()->with('info', 'File C1 untuk polling place ini sudah diupload.');
            }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('File_C1', 'public');
                Log::info('File berhasil disimpan.', ['path' => $path]);

                Filec1::create([
                    'tps_realcount_id' => $request->tps_realcount_id,
                    'file' => $path
                ]);
                DB::commit();
                Log::info('File C1 berhasil diupload.', ['tps_realcount_id' => $request->tps_realcount_id]);
                return redirect()->route('file-c1.index')->with('success', 'File C1 berhasil diupload.');
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

    public function destroy($file_c1)
    {
        DB::beginTransaction();
        try {
            $fileC1 = Filec1::findOrFail($file_c1);
            if (Storage::disk('public')->exists($fileC1->file)) {
                Storage::disk('public')->delete($fileC1->file);
                Log::info('File berhasil dihapus dari storage.', ['path' => $fileC1->file]);
            } else {
                Log::warning('File tidak ditemukan di storage.', ['path' => $fileC1->file]);
            }
            $fileC1->delete();
            DB::commit();

            Log::info('File C1 berhasil dihapus.', ['id' => $file_c1]);
            return redirect()->route('file-c1.index')->with('success', 'File C1 berhasil dihapus.');
        } catch (\Throwable $th) {
            DB::rollBack();
            Log::error('Gagal menghapus file.', ['error' => $th->getMessage()]);
            return redirect()->back()->with('error', 'Gagal menghapus file.');
        }
    }
}
