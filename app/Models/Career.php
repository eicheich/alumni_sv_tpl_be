<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Career extends Model
{
    /** @use HasFactory<\Database\Factories\CareerFactory> */
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'company_name',
        'position',
        'start_date',
        'end_date',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }


}
