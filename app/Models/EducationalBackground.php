<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EducationalBackground extends Model
{
    /** @use HasFactory<\Database\Factories\EducationalBackgroundFactory> */
    use HasFactory;

    protected $fillable = [
        'alumni_id',
        'institution_name',
        'degree',
        'entry_year',
        'graduation_year',
        'major',
        'faculty',
    ];

    public function alumni()
    {
        return $this->belongsTo(Alumni::class);
    }
}
