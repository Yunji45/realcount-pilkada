<?php

namespace App\Http\Controllers;

use App\Models\Election;
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

        // return view('');
        return $elections;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $elections = Election::all();

        // return view('');
        return $elections;
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name_pilkada' => ['required', 'string', 'max:255'],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $election = Election::create([
                'name_pilkada' => $request->name_pilkada,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            DB::commit();

            return redirect()->route('elections.index')->with('success', 'Election created successfully');
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
        // return view('');
        return $election;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Election $election)
    {
        // return view('');
        return $election;
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Election $election)
    {
        DB::beginTransaction();
        try {
            $validator = Validator::make($request->all(), [
                'name_pilkada' => ['required', 'string', 'max:255'],
                'start_date' => ['required', 'date'],
                'end_date' => ['required', 'date', 'after_or_equal:start_date'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $election->update([
                'name_pilkada' => $request->name_pilkada,
                'start_date' => $request->start_date,
                'end_date' => $request->end_date,
            ]);

            DB::commit();

            return redirect()->route('elections.index')->with('success', 'Election updated successfully');
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
            $election->delete();

            DB::commit();

            return redirect()->route('elections.index')->with('success', 'Election deleted successfully');
        } catch (\Throwable $th) {
            DB::rollBack();
            return back()->with('error', 'Election deletion failed');
        }
    }
}
