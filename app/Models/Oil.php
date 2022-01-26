<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Translatable;

class Oil extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $table = 'oil';
    protected $fillable = ['brand_id', 'type_id', 'name', 'serial_number', 'description','price', 'quantity', 'image', 'status'];

    public function brand()
    {
        return $this->belongsTo(OilBrand::class);
    }

    public function type()
    {
        return $this->belongsTo(OilType::class);
    }

    public function coupons()
    {
      return $this->hasMany(Coupon::class);
    }
}
