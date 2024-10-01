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
    //realcount
    public function realcount()
    {
        $vote = Votec1::sum('real_count');
        $tps = Votec1::distinct('tps_realcount_id')->count('tps_realcount_id');
        $candidate = Votec1::distinct('candidate_id')->count('candidate_id');
        $candidateId = Votec1::select('candidate_id', DB::raw('SUM(real_count) as total_votes'))
                                ->groupBy('candidate_id')
                                ->get();
        // foreach ($candidateId as $candidates){
        //     $candidatesf[] = $candidates->name;
        // }
        // return $candidatesf;
        return view('realcount.page',compact('vote','tps','candidate','candidateId' ));
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
