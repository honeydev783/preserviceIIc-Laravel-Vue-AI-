<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SoilConditions extends Model
{
    use HasFactory;
    protected $fillable = [
        'category', 'sandy_soil', 'loam_soil', 'soft_clay_soil', 'stiff_clay_soil', 'hard_soil', 'soft_soil', 'ordinary_soil'
    ];
}
