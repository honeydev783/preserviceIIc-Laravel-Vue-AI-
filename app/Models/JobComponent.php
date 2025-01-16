<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class JobComponent extends Model
{
    use HasFactory;

    protected $table ='job_component';

    protected $fillable =[
        'job_id',
        'comonent_id',
        'quantity'
    ];


    public function job(){
        return $this->belongsTo(JobActivities::class,'job_id');
    }
    public function component(){
        return $this->belongsTo(ResourceComponents::class,'component_id');
    }
   
}
