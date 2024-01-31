<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CustomerSubmitProduct extends Model
{
    use HasFactory;

    use SoftDeletes;

    protected $fillable = ["customer_submit_id", "pdt_group_id", "pdt_id", "pdt_color", "pdt_price", "customer_comment"];

    public function product()
    {
        return $this->hasOne(Product::class, "id", "pdt_id");
    }
}
