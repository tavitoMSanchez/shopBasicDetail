<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Models\Car;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function Car()
    {
        return $this->hasMany(Car::class,'product_id', 'id');
    }

    protected $fillable = ['name','description','price','levy'];
}
