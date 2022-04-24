<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Car extends Model
{
    use HasFactory;

    public function CarProducts()
    {
        return $this->belongsTo(Product::class);
    }

    protected $fillable = ['id','product_id','user_id'];
}
