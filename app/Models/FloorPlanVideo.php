<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FloorPlanVideo extends Model
{
    use HasFactory;
    protected $fillable = [
        'floor_plan_id',
        'vid_name',
        'vid_url',
        'vid_key',
    ];
}
