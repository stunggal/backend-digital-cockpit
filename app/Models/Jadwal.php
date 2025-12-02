<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Carbon;

class Jadwal extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * - `pasien_id`, `dokter_id`: foreign keys
     * - `tanggal`: appointment date (Y-m-d)
     * - `jam`: appointment time (H:i)
     * - `keluhan`: patient's complaint or reason for visit
     * - `status`: optional status string
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'pasien_id',
        'dokter_id',
        'tanggal',
        'jam',
        'keluhan',
        'status',
    ];

    /**
     * Relationship: the pasien (patient) for this jadwal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function pasien(): BelongsTo
    {
        return $this->belongsTo(Pasien::class);
    }

    /**
     * Relationship: the dokter (doctor) for this jadwal.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function dokter(): BelongsTo
    {
        return $this->belongsTo(Dokter::class);
    }

    /**
     * Retrieve past jadwal entries (before now) optionally filtered by
     * pasien_id and/or dokter_id.
     *
     * - `$pasien_id`: optional pasien id to filter by
     * - `$dokter_id`: optional dokter id to filter by
     *
     * Returns a Collection of matching Jadwal models.
     *
     * @param int|null $pasien_id
     * @param int|null $dokter_id
     * @return \Illuminate\Database\Eloquent\Collection
     */
    public static function getJadwalPasts(?int $pasien_id = null, ?int $dokter_id = null)
    {
        // Compare the `tanggal` column to today's date. If your application
        // stores datetime instead of date, adjust the comparison accordingly.
        $today = now()->toDateString();
        $query = self::where('tanggal', '<', $today);

        if ($pasien_id) {
            $query->where('pasien_id', $pasien_id);
        }

        if ($dokter_id) {
            $query->where('dokter_id', $dokter_id);
        }

        return $query->get();
    }

    /**
     * Helper: returns true when this jadwal is in the past relative to
     * the server date. This combines `tanggal` and `jam` into a single
     * datetime for comparison.
     *
     * @return bool
     */
    public function isPast(): bool
    {
        // If `tanggal` or `jam` are missing consider the jadwal not past
        if (empty($this->tanggal) || empty($this->jam)) {
            return false;
        }

        try {
            $scheduled = Carbon::createFromFormat('Y-m-d H:i', $this->tanggal . ' ' . $this->jam);
            return $scheduled->isPast();
        } catch (\Exception $e) {
            // If parsing fails, log and return false to avoid breaking callers.
            return false;
        }
    }
}
