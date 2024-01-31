<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Customer extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $fillable = [
        'name', "source_webiste", "contractor_id", "email", "phone", "home_location", "home_zip", "home_state", "note"
    ];

    public function submits()
    {
        return $this->hasMany(CustomerSubmit::class);
    }
}
