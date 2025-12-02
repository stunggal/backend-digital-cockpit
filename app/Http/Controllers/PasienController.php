<?php

namespace App\Http\Controllers;

use App\Models\Pasien;
use Illuminate\Http\Request;

class PasienController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return a paginated list of patients. Example:
        // return response()->json(Pasien::paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Return a creation form for web apps. For APIs this method is
        // commonly left empty or removed.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store a new patient record. Example validation:
        // $validated = $request->validate(['nama' => 'required|string', 'email' => 'nullable|email', 'telepon' => 'nullable|string']);
        // return response()->json(Pasien::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Pasien $pasien)
    {
        // Return a single patient resource. Use route-model binding.
        // return response()->json($pasien);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Pasien $pasien)
    {
        // Return an edit form view for web apps. Not typically used for APIs.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Pasien $pasien)
    {
        // Validate incoming fields and update the pasien record.
        // $validated = $request->validate(['nama' => 'sometimes|string', 'email' => 'sometimes|email']);
        // $pasien->update($validated);
        // return response()->json($pasien);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Pasien $pasien)
    {
        // Remove the pasien and return a 204 No Content response.
        // $pasien->delete();
        // return response()->json(null, 204);
    }
}
