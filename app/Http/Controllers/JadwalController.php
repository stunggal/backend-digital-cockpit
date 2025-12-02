<?php

namespace App\Http\Controllers;

use App\Models\Jadwal;
use Illuminate\Http\Request;

class JadwalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // List jadwal entries. Consider paginating for large datasets.
        // return response()->json(Jadwal::with(['pasien','dokter'])->paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a form for creating an appointment (web). API controllers
        // often omit this method.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and create a new appointment. Example rules:
        // $validated = $request->validate(['pasien_id' => 'required|integer', 'dokter_id' => 'required|integer', 'tanggal' => 'required|date', 'jam' => 'required']);
        // return response()->json(Jadwal::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Jadwal $jadwal)
    {
        // Show a single appointment; route-model binding provides $jadwal.
        // return response()->json($jadwal->load(['pasien','dokter']));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Jadwal $jadwal)
    {
        // Web-only: return an edit form. For APIs this can be removed.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Jadwal $jadwal)
    {
        // Validate and apply updates to the appointment.
        // $validated = $request->validate(['tanggal' => 'sometimes|date', 'jam' => 'sometimes']);
        // $jadwal->update($validated);
        // return response()->json($jadwal);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Jadwal $jadwal)
    {
        // Cancel/delete the appointment. Consider soft deletes if you need history.
        // $jadwal->delete();
        // return response()->json(null, 204);
    }
}
