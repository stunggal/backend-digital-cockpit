<?php

namespace App\Http\Controllers;

use App\Models\Dokter;
use Illuminate\Http\Request;

class DokterController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return a list of doctors. Example:
        // return response()->json(Dokter::paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Web-only: return creation view; omit for API-only controllers.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and create a new Dokter. Example:
        // $validated = $request->validate(['nama' => 'required|string', 'spesialis' => 'nullable|string']);
        // return response()->json(Dokter::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Dokter $dokter)
    {
        // Return detailed dokter information, optionally with today's jadwal:
        // return response()->json($dokter->load('jadwalHariIni'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Dokter $dokter)
    {
        // Web-only: return edit view.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Dokter $dokter)
    {
        // Validate and update the dokter record. Example:
        // $validated = $request->validate(['nama' => 'sometimes|string', 'spesialis' => 'sometimes|string']);
        // $dokter->update($validated);
        // return response()->json($dokter);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Dokter $dokter)
    {
        // Delete the dokter. Consider cascade rules for related jadwal records.
        // $dokter->delete();
        // return response()->json(null, 204);
    }
}
