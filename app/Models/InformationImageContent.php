<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationImageContent extends Model
{
    /** @use HasFactory<\Database\Factories\GeneralInformationImageContentFactory> */
    use HasFactory;

    protected $fillable = [
        'general_information_id',
        'image_path',
    ];

    public function Information()
    {
        return $this->belongsTo(Information::class);
    }


}
