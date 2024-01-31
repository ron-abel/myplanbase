<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FloorPlanImage extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'floor_plan_id',
        'pic_name',
        'pic_url',
        'pic_key',
    ];
}
