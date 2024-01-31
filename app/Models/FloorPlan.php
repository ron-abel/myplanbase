<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class FloorPlan extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'plan_name',
        'contractor_id',
        'plan_description',
        'plan_price',
        "plan_additional_text",
        'note',
    ];

    public function images()
    {
        return $this->hasMany(FloorPlanImage::class);
    }
    public function videos()
    {
        return $this->hasMany(FloorPlanVideo::class);
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function ($model) {
            $model->images()->delete();
        });
    }

    public function contractors()
    {
        return $this->belongsToMany(Contractor::class);
    }

    public function owner()
    {
        return $this->hasOne(Contractor::class, 'id', 'contractor_id');
    }
}
