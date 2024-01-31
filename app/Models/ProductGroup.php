<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductGroup extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'pdt_group_name',
        'contractor_id',
        'pdt_group_description',
        "pdt_group_additional_text",
        'note',
    ];

    public function images()
    {
        return $this->hasMany(ProductGroupImage::class, "pdt_group_id");
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

    public function products()
    {
        return $this->hasMany(Product::class, 'pdt_group_id');
    }
    
    public function owner()
    {
        return $this->hasOne(Contractor::class, 'id', 'contractor_id');
    }
}
