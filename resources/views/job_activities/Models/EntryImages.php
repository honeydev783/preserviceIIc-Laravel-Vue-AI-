<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class EntryImages extends Model
{
    use HasFactory;
    protected $table = 'entry_images';
    
    protected $fillable = [      
        'image_name',
        'category'
    ];
}
