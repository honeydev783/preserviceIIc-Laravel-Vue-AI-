<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobActivities extends Model
{
    use HasFactory;
    protected $table = 'job_activities';
    
    protected $fillable = [      
        'description',
        'activity_code',
        'category',
        'components',
        'component_ids',
        'quantity',
        'country_id',
        'imperial_unit',
        'metric_unit',
        'conservation_factor',
        'position_order'
    ];
    
     public function scopeFilter ($query, $filters) {

        if (isset($filters['category']) && $category = $filters['category']) {
            $query->where('category',$category);
        }
    }
    
    public function resources(){
        return $this->hasMany(JobComponent::class,'job_id');
    }
    
    public function countrys(){        
        return $this->belongsTo(Countries::class,'country_id');
    }
}
