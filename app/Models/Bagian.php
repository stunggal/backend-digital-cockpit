<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Bagian extends Model
{
    /** @use HasFactory<\Database\Factories\BagianFactory> */
    use HasFactory;

    /**
     * Mass assignable attributes for a Bagian (department/section).
     * Adjust this list if your `bagians` table has additional columns.
     *
     * @var array<int,string>
     */
    protected $fillable = [
        'nama',
    ];
}
