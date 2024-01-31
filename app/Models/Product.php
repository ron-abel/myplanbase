<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'pdt_name',
        'pdt_group_id',
        'contractor_id',
        'pdt_description',
        "pdt_additional_text",
        "pdt_price"
    ];

    public function images()
    {
        return $this->hasMany(ProductImage::class, "pdt_id");
    }

    public function productgroup()
    {
        return $this->belongsTo(ProductGroup::class, "pdt_group_id");
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
