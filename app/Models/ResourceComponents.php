<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ResourceComponents extends Model
{
    use HasFactory;
    protected $table = 'resource_components';
    protected $fillable = [
        'component_id',
        'resource_type',
        'quantity',
        'unit',
        'rate',
        'category',
        'country',
        'orignal_rate'
    ];

    public function countrys(){        
        return $this->belongsTo(Countries::class,'country');
    }
}
