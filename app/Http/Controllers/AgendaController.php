<?php

namespace App\Http\Controllers;

use App\Models\Agenda;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AgendaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $title = "Agenda";

        return view('dashboard.admin.agenda.index', compact('title'));
    }

    // Mengembalikan data agenda dalam format JSON
    public function getAgendas()
    {
        // Ambil semua agenda dari database
        $agendas = Agenda::select('id', 'title', 'description', 'start', 'end')
            ->get();

        // Format agenda sesuai dengan kebutuhan FullCalendar
        $formattedAgendas = $agendas->map(function ($agenda) {
            return [
                'id' => $agenda->id,
                'title' => $agenda->title,
                'start' => $agenda->start,
                'end' => $agenda->end,
                'description' => $agenda->description
            ];
        });

        return response()->json($formattedAgendas);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Buat event baru
        $agenda = Agenda::create([
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end ?? $request->start, // Jika tidak ada end date, set sama dengan start
        ]);

        return response()->json([
            'success' => true,
            'agenda' => $agenda
        ]);
    }


    /**
     * Display the specified resource.
     */
    public function show(Agenda $agenda)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Agenda $agenda)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Agenda $agenda)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start' => 'required|date',
            'end' => 'nullable|date|after_or_equal:start'
        ]);

        // Jika validasi gagal, kembalikan error
        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => $validator->errors()->first()
            ], 422);
        }

        // Update data agenda
        $agenda->update([
            'title' => $request->title,
            'description' => $request->description,
            'start' => $request->start,
            'end' => $request->end ?? $request->start, // Jika tidak ada tanggal akhir, set sama dengan start
        ]);

        // Kembalikan respons sukses
        return response()->json([
            'success' => true,
            'agenda' => $agenda
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Agenda $agenda)
    {
        try {
            $agenda->delete();
            return response()->json([
                'success' => true,
                'message' => 'Agenda berhasil dihapus!'
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan saat menghapus agenda: ' . $e->getMessage()
            ], 500);
        }
    }
}
