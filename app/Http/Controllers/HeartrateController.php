<?php

namespace App\Http\Controllers;

use App\Models\Heartrate;
use Illuminate\Http\Request;

class HeartrateController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return a listing of heartrate readings. Example:
        // return response()->json(Heartrate::paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Web-only: return creation form. For APIs this method is usually
        // unnecessary and can be removed.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store a heart rate reading. Example:
        // $validated = $request->validate(['rate' => 'required', 'time' => 'required|date']);
        // return response()->json(Heartrate::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Heartrate $heartrate)
    {
        // Return the requested heart rate record.
        // return response()->json($heartrate);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Heartrate $heartrate)
    {
        // Web-only: return edit form.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Heartrate $heartrate)
    {
        // Validate and update the record. Example:
        // $validated = $request->validate(['rate' => 'sometimes', 'time' => 'sometimes|date']);
        // $heartrate->update($validated);
        // return response()->json($heartrate);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Heartrate $heartrate)
    {
        // Delete the record and return 204 No Content on success.
        // $heartrate->delete();
        // return response()->json(null, 204);
    }
}
