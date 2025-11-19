<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AlumniOtp extends Model
{
    /** @use HasFactory<\Database\Factories\AlumniOtpFactory> */
    use HasFactory;

    protected $fillable = [
        'user_id',
        'otp_code',
        'expires_at',
        'is_verified',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function isExpired()
    {
        return $this->expires_at < now();
    }
}
