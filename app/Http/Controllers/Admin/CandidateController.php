<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Candidate;
use App\Models\Election;
use App\Models\Partai;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class CandidateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $candidates = Candidate::with('partai', 'election')
            ->get();

        $title = 'Kandidat';

        return view('dashboard.admin.candidate.index', compact('candidates', 'title'));
        // return $candidate;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $partais = Partai::all();
        $elections = Election::all();
        $title = 'Kandidat';
        $type = 'Tambah Data';

        return view('dashboard.admin.candidate.create', compact('partais', 'elections', 'title', 'type'));
        // return $candidate;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            // Validasi data input
            $validator = Validator::make($request->all(), [
                'name' => ['nullable', 'string', 'max:255'],
                'partai_id' => ['required', 'exists:partais,id'], // Validasi partai_id harus ada di tabel partai
                'election_id' => ['required', 'exists:elections,id'], // Validasi election_id harus ada di tabel election
                'vision' => ['required', 'string'],
                'mision' => ['required', 'string'],
                'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
            ]);

            // Jika validasi gagal, kembali dengan pesan kesalahan
            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            // Simpan foto jika diunggah
            $photoPath = null;
            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $photoName = time() . "_" . $file->getClientOriginalName();
                $photoPath = $file->storeAs('photos/candidates', $photoName, 'public');
            }

            // Simpan data kandidat ke dalam database
            $candidate = Candidate::create([
                'name' => $request->name,
                'partai_id' => $request->partai_id, // Relasi dengan partai
                'election_id' => $request->election_id, // Relasi dengan election
                'vision' => $request->vision,
                'mision' => $request->mision,
                'photo' => $photoPath,
            ]);

            // Commit transaksi
            DB::commit();

            // Redirect ke halaman index kandidat dengan pesan sukses
            return redirect()->route('candidate.index')->with('success', 'Candidate created successfully');
        } catch (\Throwable $th) {
            // Rollback jika ada kesalahan
            DB::rollBack();

            dd($th->getMessage());
            return back()->with('error', 'Candidate creation failed');
        }
    }



    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        return view('dashboard.admin.candidate.show');
        // return $candidate;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        $partais = Partai::all();
        $elections = Election::all();
        $title = 'Kandidat';
        $type = 'Edit Data';

        return view('dashboard.admin.candidate.edit', compact('candidate', 'partais', 'elections', 'title', 'type'));
        // return $candidate;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Candidate $candidate)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['required', 'string', 'max:255'],
                'partai_id' => ['required', 'exists:partais,id'], // Validasi partai_id harus ada di tabel partai
                'election_id' => ['required', 'exists:elections,id'], // Validasi election_id harus ada di tabel election
                'vision' => ['required', 'string'],
                'mision' => ['required', 'string'],
                'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $photoPath = $candidate->photo;

            if ($request->hasFile('photo')) {
                // Delete old photo if it exists
                if ($candidate->photo && Storage::disk('public')->exists($candidate->photo)) {
                    Storage::disk('public')->delete($candidate->photo);
                }

                $file = $request->file('photo');
                $photoName = time() . "_" . $file->getClientOriginalName();
                $photoPath = $file->storeAs('photos/candidates', $photoName, 'public');
            }

            $candidate->update([
                'name' => $request->name,
                'partai_id' => $request->partai_id,
                'election_id' => $request->election_id,
                'vision' => $request->vision,
                'mision' => $request->mision,
                'photo' => $photoPath,
            ]);

            DB::commit();

            return redirect()->route('candidate.index')->with('success', 'Candidate updated successfully');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Candidate updated failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Candidate $candidate)
    {
        DB::beginTransaction();
        try {
            if ($candidate->photo && Storage::disk('public')->exists($candidate->photo)) {
                Storage::disk('public')->delete($candidate->photo);
            }

            $candidate->delete();

            DB::commit();

            return redirect()->route('candidate.index')->with('success', 'Candidate deleted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', 'Candidate deletion failed. The candidate is still referenced in another table.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'An unexpected error occurred.');
        }
    }
}
