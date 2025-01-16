<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ActivityDescription extends Model
{
    use HasFactory;
    protected $table = 'activity_descriptions';
    
    protected $fillable = [      
        'title',   
    ];
}
