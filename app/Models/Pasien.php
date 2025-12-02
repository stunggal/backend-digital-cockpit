<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;

class Pasien extends Model
{
    use HasFactory;

    /**
     * Mass assignable attributes.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'nama',
        'alamat',
        'telepon',
        'email',
        'avatar',
    ];

    /**
     * Relationship: all medical checkups (jadwal) for this patient.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicalCheckup(): HasMany
    {
        return $this->hasMany(Jadwal::class);
    }

    /**
     * Relationship: past medical checkups (history) for this patient.
     *
     * This scopes jadwal records to those before now (either a previous date
     * or earlier today based on the `jam` field).
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function medicalCheckupHistory(): HasMany
    {
        return $this->hasMany(Jadwal::class)
            ->where(function ($query) {
                $query->where('tanggal', '<', now()->toDateString())
                    ->orWhere(function ($query) {
                        $query->where('tanggal', '=', now()->toDateString())
                            ->where('jam', '<', now()->format('H:i:s'));
                    });
            });
    }

    /**
     * Return a random Dokter instance or null if none exist.
     *
     * Useful for demo data or assigning a default doctor for UI examples.
     *
     * @return \App\Models\Dokter|null
     */
    public static function getRandomDokter(): ?Dokter
    {
        return Dokter::inRandomOrder()->first();
    }

    /**
     * Helper: calculate the patient's age in years when `tanggal_lahir` is
     * present on the model. Returns null if no valid birth date is available.
     *
     * @return int|null
     */
    public function age(): ?int
    {
        if (empty($this->tanggal_lahir)) {
            return null;
        }

        try {
            $dob = Carbon::parse($this->tanggal_lahir);
            return $dob->age;
        } catch (\Exception $e) {
            return null;
        }
    }
}
