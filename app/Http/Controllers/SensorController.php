<?php

namespace App\Http\Controllers;

use App\Models\SensorData;
use App\Models\SprayerLog;
use App\Models\KipasLog;
use App\Models\LampuLog;
use Illuminate\Http\Request;

class SensorController extends Controller
{
    /**
 * Mengambil data sensor terbaru untuk Dashboard.
 * Prioritas: Manual Log > Sensor Data (otomatis dari ESP)
 */
public function latest()
{
    $latest = SensorData::latest('id')->first();

    if (!$latest) {
        return response()->json([
            'suhu' => 0,
            'kelembapan' => 0,
            'amonia' => 0,
            'status' => 'menunggu',
            'created_at' => now()->format('Y-m-d H:i:s'),
            'sprayer_active' => false,
            'kipas_active' => false,
            'lampu_active' => false,
        ]);
    }

    // ✅ FIX: Cek manual log dulu, jika tidak ada gunakan status otomatis dari SensorData
    $latestSprayer = SprayerLog::latest('id')->first();
    $latestKipas   = KipasLog::latest('id')->first();
    $latestLampu   = LampuLog::latest('id')->first();

    // Prioritas: Manual Log (dari tombol) > Sensor Data (dari ESP otomatis)
    $sprayerActive = $latestSprayer 
        ? ($latestSprayer->aksi === 'aktif')
        : (bool)$latest->sprayer_active;  // ✅ Fallback ke SensorData

    $kipasActive = $latestKipas 
        ? ($latestKipas->aksi === 'aktif')
        : (bool)$latest->kipas_active;    // ✅ Fallback ke SensorData

    $lampuActive = $latestLampu 
        ? ($latestLampu->aksi === 'aktif')
        : (bool)$latest->lampu_active;    // ✅ Fallback ke SensorData

    return response()->json([
        'suhu' => $latest->suhu,
        'kelembapan' => $latest->kelembapan,
        'amonia' => $latest->amonia,
        'status' => $latest->status,
        'created_at' => $latest->created_at->format('Y-m-d H:i:s'),
        'sprayer_active' => $sprayerActive,
        'kipas_active' => $kipasActive,
        'lampu_active' => $lampuActive,
    ]);
}

    /**
     * Mengaktifkan/menonaktifkan sprayer secara manual dari Dashboard.
     * ESP8266 akan membaca status ini melalui endpoint espSprayerStatus().
     */
    public function toggleSprayer(Request $request)
    {
        $latestSprayer = SprayerLog::latest('id')->first();

        $currentlyActive = $latestSprayer
            ? ($latestSprayer->aksi === 'aktif')
            : false;

        $newAction = $currentlyActive ? 'nonaktif' : 'aktif';

        SprayerLog::create([
            'aksi' => $newAction,
            'triggered_by' => 'manual',
        ]);

        return response()->json([
            'success' => true,
            'active' => $newAction === 'aktif',
            'message' => $newAction === 'aktif'
                ? '🚨 Penyemprot Amonia berhasil AKTIF!'
                : '✅ Penyemprot Amonia berhasil DINONAKTIFKAN!'
        ]);
    }

    /**
     * Mengaktifkan/menonaktifkan kipas secara manual dari Dashboard.
     * ESP8266 akan membaca status ini melalui endpoint espSprayerStatus().
     */
    public function toggleKipas(Request $request)
    {
        $latestKipas = KipasLog::latest('id')->first();

$currentlyActive = $latestKipas
    ? ($latestKipas->aksi === 'aktif')
    : false;

        $newAction = $currentlyActive ? 'nonaktif' : 'aktif';

        KipasLog::create([
            'aksi' => $newAction,
            'triggered_by' => 'manual',
        ]);

        return response()->json([
            'success' => true,
            'active' => $newAction === 'aktif',
            'message' => $newAction === 'aktif'
                ? '💨 Kipas berhasil AKTIF!'
                : '✅ Kipas berhasil DINONAKTIFKAN!'
        ]);
    }

    /**
     * Mengaktifkan/menonaktifkan lampu secara manual dari Dashboard.
     * ESP8266 akan membaca status ini melalui endpoint espSprayerStatus().
     */
    public function toggleLampu(Request $request)
    {
        $latestLampu = LampuLog::latest('id')->first();

$currentlyActive = $latestLampu
    ? ($latestLampu->aksi === 'aktif')
    : false;

        $newAction = $currentlyActive ? 'nonaktif' : 'aktif';

        LampuLog::create([
            'aksi' => $newAction,
            'triggered_by' => 'manual',
        ]);

        return response()->json([
            'success' => true,
            'active' => $newAction === 'aktif',
            'message' => $newAction === 'aktif'
                ? '💡 Lampu Pemanas berhasil AKTIF!'
                : '✅ Lampu Pemanas berhasil DINONAKTIFKAN!'
        ]);
    }

    // =====================================================
    // API ENDPOINTS UNTUK ESP8266
    // =====================================================

    /**
     * ESP8266 mengirim data sensor ke sini.
     * POST /api/esp/sensor
     * Body: { "suhu": 31.2, "kelembapan": 65.0, "amonia": 12.5, "kipas_active": false, "lampu_active": false }
     */
    public function espStoreSensor(Request $request)
    {
        $validated = $request->validate([
            'suhu' => 'required|numeric',
            'kelembapan' => 'required|numeric',
            'amonia' => 'required|numeric',
            'kipas_active' => 'sometimes|boolean',
            'lampu_active' => 'sometimes|boolean',
            'sprayer_active' => 'sometimes|boolean',
        ]);

        // Penentuan status berdasarkan ambang batas bahaya
        $suhu = $validated['suhu'];
        $kelembapan = $validated['kelembapan'];
        $amonia = $validated['amonia'];

        if ($suhu > 35.0 || $amonia > 25.0 || $kelembapan < 40.0 || $kelembapan > 80.0) {
            $status = 'bahaya';
        } elseif ($suhu > 33.0 || $amonia > 20.0 || $kelembapan < 50.0 || $kelembapan > 75.0) {
            $status = 'waspada';
        } else {
            $status = 'normal';
        }

        $sensorData = SensorData::create([
            'suhu' => $suhu,
            'kelembapan' => $kelembapan,
            'amonia' => $amonia,
            'status' => $status,
            'kipas_active' => $validated['kipas_active'] ?? false,
            'lampu_active' => $validated['lampu_active'] ?? false,
            'sprayer_active' => $validated['sprayer_active'] ?? false,
        ]);

        return response()->json([
            'success' => true,
            'id' => $sensorData->id,
            'status' => $status,
        ]);
    }

    /**
     * ESP8266 mengecek status sprayer/pompa dari sini.
     * GET /api/esp/sprayer-status
     * Response: { "sprayer_active": true/false }
     *
     * Jika user menekan tombol "Aktifkan Penyemprot" di dashboard,
     * maka ESP akan membaca sprayer_active = true dan menyalakan pompa.
     */
    public function espSprayerStatus()
    {
        $latestSprayer = SprayerLog::latest('id')->first();
        $sprayerActive = $latestSprayer ? ($latestSprayer->aksi === 'aktif') : false;

        $latestKipas = KipasLog::latest('id')->first();
        $kipasActive = $latestKipas ? ($latestKipas->aksi === 'aktif') : false;

        $latestLampu = LampuLog::latest('id')->first();
        $lampuActive = $latestLampu ? ($latestLampu->aksi === 'aktif') : false;

        return response()->json([
            'sprayer_active' => $sprayerActive,
            'kipas_active' => $kipasActive,
            'lampu_active' => $lampuActive,
            'sprayer_ts' => $latestSprayer ? $latestSprayer->created_at->timestamp : 0,
            'kipas_ts' => $latestKipas ? $latestKipas->created_at->timestamp : 0,
            'lampu_ts' => $latestLampu ? $latestLampu->created_at->timestamp : 0,
        ]);
    }
}
