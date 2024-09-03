<?php

namespace App\Http\Controllers;

use App\Models\Candidate;
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
        $candidate = Candidate::all();

        // return view('');
        return $candidate;
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $candidate = Candidate::all();

        // return view('');
        return $candidate;
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
                'supporting_parties' => ['required', 'string'],
                'vision' => ['required', 'string'],
                'mision' => ['required', 'string'],
                'photo' => ['nullable', 'image', 'max:2048', 'mimes:jpg,png,jpeg'],
            ]);

            if ($validator->fails()) {
                return back()->withErrors($validator)->withInput();
            }

            $photoPath = null;

            if ($request->hasFile('photo')) {
                $file = $request->file('photo');
                $photoName = time() . "_" . $file->getClientOriginalName();
                $photoPath = $file->storeAs('photos/candidates', $photoName, 'public');
            }

            $candidate = Candidate::create([
                'name' => $request->name,
                'supporting_parties' => $request->supporting_parties,
                'vision' => $request->vision,
                'mision' => $request->mision,
                'photo' => $photoPath,
            ]);

            DB::commit();

            return redirect()->route('candidates.index')->with('success', 'Candidate created successfully');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Candidate created failed');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Candidate $candidate)
    {
        // return view('');
        return $candidate;
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Candidate $candidate)
    {
        // return view('');
        return $candidate;
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
                'supporting_parties' => ['required', 'string'],
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
                'supporting_parties' => $request->supporting_parties,
                'vision' => $request->vision,
                'mision' => $request->mision,
                'photo' => $photoPath,
            ]);

            DB::commit();

            return redirect()->route('candidates.index')->with('success', 'Candidate updated successfully');
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

            return redirect()->route('candidates.index')->with('success', 'Candidate deleted successfully');
        } catch (\Throwable $th) {
            //throw $th;
            DB::rollBack();
            return back()->with('error', 'Candidate deleted failed');
        }
    }
}
