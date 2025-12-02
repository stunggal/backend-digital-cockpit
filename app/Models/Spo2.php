<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Spo2 extends Model
{
    /** @use HasFactory<\Database\Factories\Spo2Factory> */
    use HasFactory;

    /**
     * Attributes for SpO2 (oxygen saturation) readings.
     * - `oxygen`: percentage saturation
     * - `time`: when the reading was taken
     * - `user_id`: owner of the reading
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'oxygen',
        'time',
        'user_id',
    ];
}
