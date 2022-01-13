<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Translatable;

class CarModel extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $table = 'car_models';
    protected $fillable = ['brand_id', 'title', 'description'];

    public function brand()
    {
        return $this->belongsTo(CarBrand::class);
    }
}
