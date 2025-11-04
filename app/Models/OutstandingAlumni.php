<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OutstandingAlumni extends Model
{
    /** @use HasFactory<\Database\Factories\OutstandingAlumniFactory> */
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'reward_title',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
