<?php

namespace App\Http\Controllers;

use App\Models\Spo2;
use Illuminate\Http\Request;

class Spo2Controller extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return a paginated list of SpO2 readings.
        // Example implementation (uncomment when ready):
        // return response()->json(Spo2::paginate(15));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // For API-only controllers this is typically unused. Web controllers
        // may return a view with a creation form here.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and persist a new SpO2 reading.
        // Example (adjust rules to your schema):
        // $validated = $request->validate(['oxygen' => 'required|numeric', 'time' => 'required|date', 'user_id' => 'required|integer']);
        // return response()->json(Spo2::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Spo2 $spo2)
    {
        // Return a single SpO2 resource. Route-model binding provides $spo2.
        // return response()->json($spo2);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Spo2 $spo2)
    {
        // For API-only controllers this is typically unused. Web controllers
        // may return a view for editing here.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Spo2 $spo2)
    {
        // Validate and update the given SpO2 record.
        // $validated = $request->validate(['oxygen' => 'sometimes|numeric', 'time' => 'sometimes|date']);
        // $spo2->update($validated);
        // return response()->json($spo2);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Spo2 $spo2)
    {
        // Delete the resource and return a 204 No Content response on success.
        // $spo2->delete();
        // return response()->json(null, 204);
    }
}
