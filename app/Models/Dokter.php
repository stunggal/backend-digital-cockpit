<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Dokter extends Model
{
    /** @use HasFactory<\Database\Factories\DokterFactory> */
    use HasFactory;

    /**
     * Mass-assignable attributes for the Dokter model.
     *
     * - `nama`: doctor's full name
     * - `spesialis`: medical specialty
     * - `alamat`, `telepon`, `email`: contact information
     * - `avatar`: filename or URL for profile image
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'nama',
        'spesialis',
        'alamat',
        'telepon',
        'email',
        'avatar',
    ];

    /**
     * Relationship: all Jadwal (appointments) for this dokter.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwal(): HasMany
    {
        // Standard hasMany relation to the Jadwal model
        return $this->hasMany(Jadwal::class);
    }

    /**
     * Relationship: Jadwal entries for today for this dokter, ordered by time.
     *
     * This convenience relation scopes the doctor's jadwal to the current
     * date (server timezone). If your application supports multiple timezones
     * you may want to pass a date parameter instead of using `date('Y-m-d')`.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function jadwalHariIni(): HasMany
    {
        // Use PHP date in Y-m-d format to match the `tanggal` column format
        // and order results ascending by `jam` so the earliest appointment is first.
        return $this->hasMany(Jadwal::class)
            ->where('tanggal', date('Y-m-d'))
            ->orderBy('jam', 'asc');
    }

    /**
     * Helper: Return the number of jadwal entries this dokter has today.
     *
     * This small helper provides a simple integer count and keeps callers
     * from needing to load the entire relationship when only the count is
     * required.
     *
     * @return int
     */
    public function getTodayJadwalCount(): int
    {
        return $this->jadwalHariIni()->count();
    }
}
