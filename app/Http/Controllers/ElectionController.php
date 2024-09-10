<?php

namespace App\Http\Controllers;

use App\Models\Election;
use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class ElectionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $elections = Election::all();
        $title = "Pemilu";

        return view('dashboard.admin.election.index', compact('elections', 'title'));
        // return $elections;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $title = "Pemilu";
        $type = "Tambah Data";

        return view('dashboard.admin.election.create', compact('title', 'type'));
        // return $elections;
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
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
                'type' => ['required', 'string', 'max:255']
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $election = Election::create([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'type' => $request->type,
            ]);

            DB::commit();

            return redirect()->route('election.index')->with('success', 'Election created successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Election creation failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Election $election)
    {
        $title = "Pemilu";
        $type = "Lihat Data";

        return view('dashboard.admin.election.show', compact('election', 'title', 'type'));
        // return $election;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Election $election)
    {
        $title = "Pemilu";
        $type = "Edit Data";

        return view('dashboard.admin.election.edit', compact('election', 'title', 'type'));
        // return $election;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Election $election)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name' => ['sometimes', 'required', 'string', 'max:255'],
                'start_date' => ['sometimes', 'required', 'date'],
                'end_date' => ['sometimes', 'required', 'date', 'after_or_equal:start_date'],
                'type' => ['sometimes', 'required', 'string', 'max:255']
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $election->update([
                'name' => $request->name,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
                'type' => $request->type,
            ]);

            DB::commit();

            return redirect()->route('election.index')->with('success', 'Election updated successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Election update failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */

    public function destroy(Election $election)
    {
        DB::beginTransaction();
        try {
            // Hapus election
            $election->delete();

            DB::commit();

            return redirect()->route('election.index')
                ->with('success', 'Election deleted successfully');
        } catch (QueryException $e) {
            // Rollback jika terjadi error terkait basis data
            DB::rollBack();
            return back()->with('error', 'Cannot delete this election because it is being used in other records.');
        } catch (\Throwable $th) {
            // Rollback jika terjadi kesalahan umum
            DB::rollBack();
            return back()->with('error', 'Election deletion failed. Please try again.');
        }
    }

}
