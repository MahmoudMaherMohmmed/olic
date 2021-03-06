<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Translatable;

class CarBrand extends Model
{
    use HasFactory;
    use SoftDeletes;
    use Translatable; 

    protected $table = 'car_brands';
    protected $fillable = ['title', 'description', 'image'];

    public function models()
    {
        return $this->hasMany(CarModel::class);
    }
}
