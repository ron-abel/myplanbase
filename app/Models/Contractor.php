<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Contractor extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = [
        'company_name',
        'company_website',
        'sub_domain',
        'address',
        'state',
        'county',
        'zip',
        'logo',
        'business_description'
    ];

    public function owner()
    {
        return $this->hasOne(User::class, "contractor_id");
    }

    public function customers()
    {
        return $this->hasMany(Customer::class);
    }

    public function productgroups()
    {
        return $this->belongsToMany(ProductGroup::class);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class);
    }

    public function floorplans()
    {
        return $this->belongsToMany(FloorPlan::class);
    }
}
