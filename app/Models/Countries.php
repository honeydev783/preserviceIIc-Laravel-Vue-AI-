<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Countries extends Model
{
    use HasFactory;
    protected $table = 'countries';
    protected $fillable = [
        'id',
        'country_name',
        'labour_rate',
        'equipment_rate',
        'material_rate'
    ];
}
