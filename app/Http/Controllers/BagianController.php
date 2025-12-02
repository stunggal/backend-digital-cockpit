<?php

namespace App\Http\Controllers;

use App\Models\Bagian;
use Illuminate\Http\Request;

class BagianController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return a list of Bagian (departments). Example:
        // return response()->json(Bagian::paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Web-only: return creation view. For APIs this method can be removed.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and create a new Bagian. Example:
        // $validated = $request->validate(['nama' => 'required|string']);
        // return response()->json(Bagian::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bagian $bagian)
    {
        // Return the requested Bagian resource.
        // return response()->json($bagian);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bagian $bagian)
    {
        // Web-only: return edit view.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bagian $bagian)
    {
        // Validate and update the Bagian record.
        // $validated = $request->validate(['nama' => 'sometimes|string']);
        // $bagian->update($validated);
        // return response()->json($bagian);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bagian $bagian)
    {
        // Delete the Bagian record. Consider constraints if other models
        // reference this table.
        // $bagian->delete();
        // return response()->json(null, 204);
    }
}
