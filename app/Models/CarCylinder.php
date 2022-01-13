<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Translatable;

class CarCylinder extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable; 

    protected $table = 'car_cylinders';
    protected $fillable = ['title', 'description'];

}
