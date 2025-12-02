<?php

namespace App\Http\Controllers;

use App\Models\Bloodpressure;
use Illuminate\Http\Request;

class BloodpressureController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Return a paginated list of blood pressure readings.
        // Example: return response()->json(Bloodpressure::paginate(20));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Web-only: return a creation view; not commonly used for APIs.
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        // Validate and store a new blood pressure reading. Example:
        // $validated = $request->validate(['systolic' => 'required|numeric', 'diastolic' => 'required|numeric', 'time' => 'required|date', 'user_id' => 'required|integer']);
        // return response()->json(Bloodpressure::create($validated), 201);
    }

    /**
     * Display the specified resource.
     */
    public function show(Bloodpressure $bloodpressure)
    {
        // Return a single blood pressure reading.
        // return response()->json($bloodpressure);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Bloodpressure $bloodpressure)
    {
        // Web-only: return an edit view.
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Bloodpressure $bloodpressure)
    {
        // Validate and update the reading. Example:
        // $validated = $request->validate(['systolic' => 'sometimes|numeric', 'diastolic' => 'sometimes|numeric']);
        // $bloodpressure->update($validated);
        // return response()->json($bloodpressure);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Bloodpressure $bloodpressure)
    {
        // Delete the resource and return 204 No Content.
        // $bloodpressure->delete();
        // return response()->json(null, 204);
    }
}
