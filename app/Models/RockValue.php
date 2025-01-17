<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class RockValue extends Model
{
    use HasFactory;
    protected $fillable = [
        'category', 'rock_value'
    ];
}
