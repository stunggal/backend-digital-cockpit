<?php

use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\HomeController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/**
 * API Routes
 *
 * Notes:
 * - Routes that require authentication are grouped with the `auth:sanctum` middleware.
 * - Keep route URIs and controller method names in sync; comments below explain
 *   each route's high-level purpose and expected authentication requirements.
 */

// Simple authenticated endpoint: returns the authenticated user (Sanctum)
Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');


// Public authentication endpoint: accepts credentials and returns a token on success
Route::post('/auth/login', [AuthController::class, 'login']);

// All routes inside this group require a valid Sanctum token
Route::middleware('auth:sanctum')->group(function () {
    // Invalidate the current token / logout the user
    Route::post('/auth/logout', [AuthController::class, 'logout']);

    // Return profile / minimal user info for the currently logged-in user
    // Payload: none (authenticated request)
    Route::post('/get-loged-user-data', [HomeController::class, 'getlogedUserData']);

    // Retrieve medical checkup history for a patient
    // Payload: typically includes `pasien_id` or `user_id` and optional date range
    Route::post('/get-data-medical-checkup-history', [HomeController::class, 'getDataMedicalCheckupHistory']);

    // Measurement endpoints — expect `pasien_id` and optional pagination/filter
    Route::post('/get-heart-rate', [HomeController::class, 'getHeartRate']);
    Route::post('/get-blood-pressure', [HomeController::class, 'getBloodPressure']);
    Route::post('/get-spo2', [HomeController::class, 'getSpo2']);

    // Get today's schedule for a doctor; payload expects `dokter_id` or `user_id`
    Route::post('/get-jadwal-dokter', [HomeController::class, 'getJadwalDokter']);

    // Patient-related endpoints
    // - `get-pasien`: fetch details for a single patient (by `pasien_id`)
    // - `get-jadwal-pasien-past`: list past appointments for a patient
    // - `get-jadwal`: list upcoming appointments / availability
    Route::post('/get-pasien', [HomeController::class, 'getPasien']);
    Route::post('/get-jadwal-pasien-past', [HomeController::class, 'getJadwalPasienPast']);
    Route::post('/get-jadwal', [HomeController::class, 'getJadwal']);

    // Return a paginated/list view of patients (search/filter parameters)
    Route::post('/get-pasien-list', [HomeController::class, 'getPasienList']);

    // Ask the LLM endpoint for recommended food (expects `patient` and `context` payload)
    Route::post('/llm-recom-food', [HomeController::class, 'llmRecomFood']);
});

// Write time-series data to InfluxDB: kept outside the auth group so it can be used
// by ingest services; if this should be protected, move it into the auth group.
// Payload: measurement name, fields, tags, timestamp
Route::post('/influxdb-write', [HomeController::class, 'influxdbWrite']);

// Public GET endpoint to fetch LLM recommendations (read-only)
Route::get('/llm-recom-food', [HomeController::class, 'llmRecomFoodGet']);

// Lightweight test endpoint — consider removing or restricting in production
Route::get('/test', [AuthController::class, 'test']);
