<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Votec1;
use App\Models\Filec1;
use App\Models\Filed1;
use App\Models\PollingPlace;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;

class RealcountController extends Controller
{
    //tps
    public function tps(Request $request)
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
    //realcount
    public function realcount()
    {
        return view('realcount.page');
    }

    public function StoreVoteRealcount(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'candidate_id' => 'required|exists:candidates,id',
                'polling_place_id' => 'required|exists:polling_places,id',
                'real_count' => 'nullable|required|string',
            ]);
    
            $fileExists = Filec1::where('polling_place_id', $request->polling_place_id)->exists();
            if ($fileExists) {
                return redirect()->back()->with('info','Maaf ,Voting sudah ditutup karna file C1 sudah diterbitkan.');
            }
            Votec1::create([
                'candidate_id' => $request->candidate_id,
                'polling_place_id' => $request->polling_place_id,
                'real_count' => $request->real_count,
                'status' => 'Open'
            ]);
            // $votec1 = new Votec1();
            // $votec1->candidate_id = $request->candidate_id;
            // $votec1->polling_place_id = $request->polling_place_id;
            // $votec1->real_count = $request->real_count;
            // $votec1->status = 'Open';
            // $votec1->save();
            DB::commit();
            return redirect()->back()->with('success','Voting berhasil ditambah.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Voting Gagal ditambah.');
        }
    }

    //file C1
    public function StoreUploadFileC1(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'polling_place_id' => 'required|exists:polling_places,id',
                'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            ]);
            $fileExists = Filec1::where('polling_place_id', $request->polling_place_id)->exists();
            if ($fileExists) {
                return redirect()->back()->with('info', 'File C1 untuk polling place ini sudah diupload.');
            }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('C1');
                
                filec1::create([
                    'polling_place_id' => $request->polling_place_id,
                    'file' => $path
                ]);
                // $fileC1 = new Filec1();
                // $fileC1->polling_place_id = $request->polling_place_id;
                // $fileC1->file = $path;
                // $fileC1->save();
                DB::commit();
                return redirect()->back()->with('success', 'File C1 berhasil diupload.');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupload file.');
        }
    }

    //File D1
    public function StoreUploadFileD1(Request $request)
    {
        DB::beginTransaction();
        try {
            $request->validate([
                'polling_place_id' => 'required|exists:polling_places,id',
                'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            ]);
            $fileExists = Filed1::where('polling_place_id', $request->polling_place_id)->exists();
            if ($fileExists) {
                return redirect()->back()->with('info', 'File D1 untuk polling place ini sudah diupload.');
            }
            if ($request->hasFile('file')) {
                $file = $request->file('file');
                $path = $file->store('D1');

                filed1::create([
                    'polling_place_id' => $request->polling_place_id,
                    'file' => $path
                ]);
                // $fileC1 = new Filed1();
                // $fileC1->polling_place_id = $request->polling_place_id;
                // $fileC1->file = $path;
                // $fileC1->save();
                DB::commit();
                return redirect()->back()->with('success', 'File D1 berhasil diupload.');
            }
        } catch (\Throwable $th) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal mengupload file.');
        }
    }
}
