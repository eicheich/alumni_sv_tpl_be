<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\InformationCategory;

class Information extends Model
{
    /** @use HasFactory<\Database\Factories\GeneralInformationFactory> */
    use HasFactory;

    protected $fillable = [
        'cover_image',
        'title',
        'content',
        'category_id',
    ];

    public function informationCategory()
    {
        return $this->belongsTo(InformationCategory::class, 'category_id');
    }
}
