<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bloodpressure extends Model
{
    /** @use HasFactory<\Database\Factories\BloodpressureFactory> */
    use HasFactory;

    /**
     * Mass-assignable attributes for Bloodpressure readings.
     * - `systolic`, `diastolic`: pressure readings in mmHg
     * - `time`: when the reading was taken
     * - `user_id`: owner of the reading
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'systolic',
        'diastolic',
        'time',
        'user_id',
    ];
}
