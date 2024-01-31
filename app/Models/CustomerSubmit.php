<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSubmit extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ["contractor_id", "customer_id", "floor_plan_id", "floor_plan_price", "note"];

    public function customersubmitproducts()
    {
        return $this->hasMany(CustomerSubmitProduct::class, "customer_submit_id");
    }

    public function floorplan()
    {
        return $this->belongsTo(FloorPlan::class, 'floor_plan_id');
    }
}
