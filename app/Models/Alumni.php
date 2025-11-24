<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Alumni extends Model
{
    /** @use HasFactory<\Database\Factories\AlumniFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'birthdate',
        'gender',
        'nim',
        'angkatan',
        'major_id',
        'is_active',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function major()
    {
        return $this->belongsTo(Major::class);
    }

    public function career()
    {
        return $this->hasOne(Career::class);
    }

    public function careers()
    {
        return $this->hasMany(Career::class);
    }

    public function educationalBackgrounds()
    {
        return $this->hasMany(EducationalBackground::class);
    }
}
