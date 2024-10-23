<?php

namespace App\Http\Controllers;

// use App\Imports\VoteImport;
use App\Models\Candidate;
use App\Models\PollingPlace;
use App\Models\Vote;
use Illuminate\Database\QueryException;
use App\Models\Provinsi;
use App\Models\Kabupaten;
use App\Models\Kecamatan;
use App\Models\Kelurahan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;
// use Maatwebsite\Excel\Facades\Excel;

class VoteController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // Pastikan 'length' ada dan lebih besar dari 0, jika tidak set nilai default misalnya 10
        $length = $request->input('length', 10); // Default ke 10 jika length tidak dikirim
        if ($length <= 0) {
            $length = 10; // Set ke 10 jika length kurang atau sama dengan 0
        }

        // Menghitung halaman saat ini berdasarkan parameter 'start' dari DataTables
        $page = ($request->start / $length) + 1;

        // Mengambil data dengan pagination
        $votes = Vote::with('candidate.partai', 'polling_place.kelurahan', 'polling_place.kecamatan', 'candidate.election')
            ->paginate($length, ['*'], 'page', $page);

        // Mengembalikan JSON response jika request dari DataTables (AJAX)
        if ($request->ajax()) {
            return response()->json([
                'draw' => intval($request->draw), // Mengirim draw count
                'recordsTotal' => $votes->total(), // Total data
                'recordsFiltered' => $votes->total(), // Total data setelah filtering
                'data' => $votes->items() // Data untuk halaman ini
            ]);
        }

        $title = "Suara";

        return view('dashboard.admin.vote.index', compact('title'));
    }



    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $candidates = Candidate::with('partai', 'election')
            ->get();
        // $candidates = Candidate::all();
        $pollingPlaces = PollingPlace::all();
        $provinsis = Provinsi::all();
        $title = "Suara";
        $type = "Tambah";

        return view('dashboard.admin.vote.create', compact('candidates', 'pollingPlaces', 'title', 'type', 'provinsis'));
        // return $candidates;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'candidate_id' => ['required', 'exists:candidates,id'],
                'polling_place_id' => ['required', 'exists:polling_places,id'],
                'vote_count' => ['required', 'string', 'max:255'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $vote = Vote::create([
                'candidate_id' => $request->candidate_id,
                'polling_place_id' => $request->polling_place_id,
                'vote_count' => $request->vote_count,
            ]);

            DB::commit();
            // return response()->json([
            //     'success' => true,
            //     'message' => 'Polling place created successfully.',
            //     'data' => $vote
            // ], 201); // 201 = Created

            return redirect()->route('vote.index')->with('success', 'Vote cast successfully');
        } catch (\Exception $e) {
            DB::rollBack();

            return back()->with('error', 'Vote casting failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Vote $vote)
    {
        $candidates = Candidate::with('partai', 'election')
            ->get();
        $pollingPlaces = PollingPlace::all();
        $title = "Suara";
        $type = "Detail";

        return view('dashboard.admin.vote.show', compact('candidates', 'pollingPlaces', 'title', 'type'));
        // return $vote;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Vote $vote)
    {
        $candidates = Candidate::with('partai', 'election')
            ->get();
        $pollingPlaces = PollingPlace::all();
        $provinsis = Provinsi::all();
        $title = "Suara";
        $type = "Edit";

        return view('dashboard.admin.vote.edit', compact('candidates', 'pollingPlaces', 'title', 'type', 'vote', 'provinsis'));
        // return $vote;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Vote $vote)
    {
        // Mulai transaksi
        DB::beginTransaction();
        try {
            // Validasi data input, menggunakan nullable untuk kolom yang tidak wajib
            $validatedData = $request->validate([
                'candidate_id' => ['nullable', 'exists:candidates,id'], // Tidak wajib diisi
                'polling_place_id' => ['nullable', 'exists:polling_places,id'], // Tidak wajib diisi
                'vote_count' => ['nullable', 'integer'], // Tidak wajib diisi
            ]);

            // Hanya update kolom yang ada di dalam input
            $vote->update(array_filter($validatedData)); // Hanya kolom yang tidak null yang akan diupdate

            // Commit transaksi jika update berhasil
            DB::commit();

            // Redirect dengan pesan sukses
            return redirect()->route('vote.index')->with('success', 'Vote updated successfully');
        } catch (\Throwable $th) {
            // Rollback jika terjadi error
            DB::rollBack();

            // Log error untuk debugging
            Log::error('Vote update failed: ' . $th->getMessage());

            // Redirect dengan pesan error
            return back()->with('error', 'Vote update failed')->withInput();
        }
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Vote $vote)
    {
        DB::beginTransaction();
        try {
            $vote->delete();

            DB::commit();

            return redirect()->route('vote.index')->with('success', 'Vote deleted successfully');
        } catch (QueryException $e) {
            DB::rollBack();
            return back()->with('error', 'Vote deletion failed. The vote is still referenced in another table.');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'An unexpected error occurred.');
        }
    }

    public function massDelete(Request $request)
    {
        $voteIds = $request->input('selected_ids'); // Ambil array ID dari request

        if (empty($voteIds)) {
            return redirect()->back()->with('error', 'No votes selected for deletion.');
        }

        DB::beginTransaction();
        try {
            Vote::whereIn('id', $voteIds)->delete(); // Hapus vote berdasarkan ID yang dipilih

            DB::commit();
            return redirect()->route('vote.index')->with('success', 'Selected votes have been deleted successfully.');
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Error deleting votes.');
        }
    }





    // Mendapatkan polling places berdasarkan kelurahan (AJAX)
    public function getPollingPlaces($kelurahanId)
    {
        $pollingPlaces = PollingPlace::where('kelurahan_id', $kelurahanId)->get();
        return response()->json($pollingPlaces);
    }

    // public function import()
    // {
    //     try {
    //         Excel::import(new VoteImport, request()->file('your_file'));

    //         return redirect()->route("vote.index")->with('success', 'Suara Berhasil Di Import!');
    //     } catch (\Throwable $th) {
    //         return back()->with("error", $th->getMessage());
    //     }
    // }
}
