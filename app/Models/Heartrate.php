<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Heartrate extends Model
{
    use HasFactory;

    /**
     * Attributes that can be mass assigned for testing and seeding.
     * - `rate`: beats per minute (may include fractional part)
     * - `time`: timestamp of the reading
     * - `user_id`: owner of the reading
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'rate',
        'time',
        'user_id',
    ];
}
