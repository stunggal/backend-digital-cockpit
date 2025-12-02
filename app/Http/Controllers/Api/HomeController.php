<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Bloodpressure;
use App\Models\Dokter;
use App\Models\Heartrate;
use App\Models\Jadwal;
use App\Models\Pasien;
use App\Models\Spo2;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use InfluxDB2\Client;
use InfluxDB2\Point;
use Illuminate\Support\Facades\Log;

class HomeController extends Controller
{
    /**
     * Controller providing several read endpoints used by the API home/dashboard.
     *
     * Each method below returns JSON and is intended to be lightweight and
     * defensive: inputs are validated or guarded and helpful 4xx/5xx responses
     * are returned when appropriate.
     */
    public function getLogedUserData(Request $request)
    {
        // Return the authenticated user object. If there's no authenticated
        // user attached to the request this returns a 401-like null response.
        $user = $request->user();
        if (!$user) {
            return response()->json(['message' => 'Not authenticated'], 401);
        }

        return response()->json($user);
    }

    public function getDataMedicalCheckupHistory(Request $request)
    {
        /**
         * Returns a pasien record including related medical checkup history
         * and the dokter who performed each checkup.
         */
        $pasien_id = $request->input('pasien_id');
        if (!$pasien_id) {
            return response()->json(['message' => 'pasien_id is required'], 400);
        }

        $pasien = Pasien::with('medicalCheckupHistory.dokter')->find($pasien_id);
        if (!$pasien) {
            return response()->json(['message' => 'Pasien tidak ditemukan.'], 404);
        }

        return response()->json($pasien, 200);
    }

    public function getHeartRate(Request $request)
    {
        // Return the latest heart rate for a user. If none exists return 0.
        $user_id = $request->input('user_id');
        if (!$user_id) {
            return response()->json(['message' => 'user_id is required'], 400);
        }

        $heartRateData = Heartrate::where('user_id', $user_id)->latest()->first();
        $heartRate = $heartRateData?->rate ?? 0;

        return response()->json($heartRate, 200);
    }

    public function getBloodPressure(Request $request)
    {
        // Return the latest blood pressure reading for a user.
        $user_id = $request->input('user_id');
        if (!$user_id) {
            return response()->json(['message' => 'user_id is required'], 400);
        }

        $bloodPressureData = Bloodpressure::where('user_id', $user_id)->latest()->first();

        $bloodPressure = [
            'systolic' => $bloodPressureData->systolic ?? 0,
            'diastolic' => $bloodPressureData->diastolic ?? 0,
        ];

        return response()->json([
            'bloodPressure' => $bloodPressure
        ]);
    }

    public function getSpo2(Request $request)
    {
        // Return latest SPO2 (oxygen saturation) for a user
        $user_id = $request->input('user_id');
        if (!$user_id) {
            return response()->json(['message' => 'user_id is required'], 400);
        }

        $spo2data = Spo2::where('user_id', $user_id)->latest()->first();
        $spo2 = $spo2data->oxygen ?? 0;

        return response()->json([
            'spo2' => $spo2
        ]);
    }

    public function getJadwalDokter(Request $request)
    {
        // Get today's schedule for a given doctor including patient details
        $dokter_id = $request->input('dokter_id');
        if (!$dokter_id) {
            return response()->json(['message' => 'dokter_id is required'], 400);
        }

        $jadwal = Dokter::with(['jadwalHariIni.pasien'])->find($dokter_id);
        if (!$jadwal) {
            return response()->json(['message' => 'Dokter tidak ditemukan.'], 404);
        }

        return response()->json($jadwal, 200);
    }

    public function getPasien(Request $request)
    {
        // Return basic pasien profile by id
        $pasien_id = $request->input('pasien_id');
        if (!$pasien_id) {
            return response()->json(['message' => 'pasien_id is required'], 400);
        }

        $pasien = Pasien::find($pasien_id);
        if (!$pasien) {
            return response()->json(['message' => 'Pasien tidak ditemukan.'], 404);
        }

        return response()->json($pasien, 200);
    }

    public function getJadwalPasienPast(Request $request)
    {
        // Return past schedules for a pasien
        $pasien_id = $request->input('pasien_id');
        if (!$pasien_id) {
            return response()->json(['message' => 'pasien_id is required'], 400);
        }

        $jadwalPasts = Jadwal::getJadwalPasts($pasien_id);
        return response()->json($jadwalPasts, 200);
    }

    public function getJadwal(Request $request)
    {
        // Return all jadwals including pasien and dokter relations
        $jadwal = Jadwal::with(['pasien', 'dokter'])->get();
        return response()->json($jadwal, 200);
    }

    public function getPasienList(Request $request)
    {
        // Return a list of all patients. Attach a random dokter to each
        // record for UI/demo purposes.
        $pasienList = Pasien::all();
        $dokters = Dokter::all();

        $pasienList->each(function ($pasien) use ($dokters) {
            $pasien->random_dokter = $dokters->isNotEmpty() ? $dokters->random() : null;
        });

        return response()->json($pasienList, 200);
    }

    public function llmRecomFood(Request $request)
    {
        // Send a description to an external webhook (n8n) to request
        // a food recommendation. This endpoint acts as a thin proxy.
        // Validate required payload early for clearer client errors.
        $request->validate([
            'deskripsi' => 'required|string',
        ]);

        // Prefer configuring the webhook URL via environment/config. A
        // fallback is provided for backwards compatibility with existing
        // deployments that used the hardcoded URL.
        $webhookUrl = env('LLM_WEBHOOK_URL', 'https://myn8n.stunggal.id/webhook/9eec2c3d-380d-4013-a66c-079eaf3f4ca6');

        $headers = [
            'Content-Type: application/json',
        ];

        $body = [
            'deskripsi' => $request->input('deskripsi'),
        ];

        try {
            $response = Http::withHeaders($headers)->get($webhookUrl, $body);
            $data = $response->json();
        } catch (\Exception $e) {
            Log::error('LLM webhook request failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to contact recommendation service'], 502);
        }

        return response()->json([
            'message' => 'This is a placeholder for LLM food recommendation.',
            'data' => $data
        ], 200);
    }

    public function llmRecomFoodGet(Request $request)
    {
        // Convenience endpoint that calls the same webhook with an example payload
        $webhookUrl = env('LLM_WEBHOOK_URL', 'https://myn8n.stunggal.id/webhook/9eec2c3d-380d-4013-a66c-079eaf3f4ca6');

        $headers = [
            'Content-Type: application/json',
        ];

        $body = [
            'deskripsi' => 'Makanan untuk Pasien Rawat Inap, Pria, usia 55 tahun, dengan diagnosis Diabetes Melitus Tipe 2 dan Gagal Jantung Kongestif (CHF). Target Kalori Harian (TKE) adalah 1700 kkal. Distribusi Makronutrien: Karbohidrat 55%, Protein 20% (tinggi untuk albumin), Lemak 25% (rendah lemak jenuh). Pembatasan Utama: Diet Rendah Garam II (maks. 1000 mg Natrium/hari) dan Pembatasan Cairan Ringan (1500 ml/hari). Tekstur makanan harus Lunak Penuh (Puree/Bubur Saring) karena masalah pengunyahan. Menu harus menyediakan protein kualitas tinggi (Ikan/Ayam Tanpa Kulit) dan sumber karbohidrat kompleks (Nasi/Bubur/Oatmeal).',
        ];

        try {
            $response = Http::withHeaders($headers)->get($webhookUrl, $body);
            $data = $response->json();
        } catch (\Exception $e) {
            Log::error('LLM webhook example request failed', ['error' => $e->getMessage()]);
            return response()->json(['message' => 'Failed to contact recommendation service'], 502);
        }

        return response()->json([
            'message' => 'This is a placeholder for LLM food recommendation.',
            'data' => $data
        ], 200);
    }

    public function influxdbWrite(Request $request)
    {
        // 1. Validate incoming sensor data
        $validated = $request->validate([
            'suhu' => 'required|numeric',
            'kelembaban' => 'required|numeric',
            'device' => 'required|string', // Device ID
        ]);

        // Read configuration from environment; guard if not set
        $url = env('INFLUXDB_URL');
        $token = env('INFLUXDB_TOKEN');
        if (!$url || !$token) {
            Log::warning('InfluxDB configuration missing');
            return response()->json(['error' => 'InfluxDB is not configured'], 500);
        }

        // Ensure org and bucket are configured — the Influx client depends on them
        $org = env('INFLUXDB_ORG');
        $bucket = env('INFLUXDB_BUCKET');
        if (!$org || !$bucket) {
            Log::warning('InfluxDB org/bucket not configured', ['org' => $org, 'bucket' => $bucket]);
            return response()->json(['error' => 'InfluxDB org or bucket not configured'], 500);
        }

        // Create a client using environment configuration. The actual array
        // keys depend on your InfluxDB client version and setup.
        $client = new Client([
            'url' => $url,
            'token' => $token,
            'org' => env('INFLUXDB_ORG'),
            'bucket' => env('INFLUXDB_BUCKET'),
        ]);

        $writeApi = $client->createWriteApi();

        // 2. Prepare the point to write. Use a measurement name that groups
        // sensor readings together.
        $point = Point::measurement('sensor_data')
            ->addTag('device_id', $validated['device'])
            ->addField('suhu', $validated['suhu'])
            ->addField('kelembaban', $validated['kelembaban'])
            ->time(time());

        try {
            $writeApi->write($point);
            $writeApi->close();

            // Return 201 (Created) on success
            return response()->json(['message' => 'Data sensor berhasil disimpan!'], 201);
        } catch (\Exception $e) {
            Log::error('Failed to write to InfluxDB', ['error' => $e->getMessage()]);
            return response()->json(['error' => 'Gagal menyimpan data: ' . $e->getMessage()], 500);
        }
    }
}
