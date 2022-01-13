<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class CarBrand extends Model
{
    use HasFactory;
    use Translatable; 

    protected $table = 'car_brands';
    protected $fillable = ['title', 'description', 'image'];
}
