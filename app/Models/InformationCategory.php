<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class InformationCategory extends Model
{
    /** @use HasFactory<\Database\Factories\InformationCategoryFactory> */
    use HasFactory;

    protected $fillable = [
        'name',
    ];

    public function generalInformation()
    {
        return $this->hasMany(GeneralInformation::class, 'category_id');
    }
    

}
