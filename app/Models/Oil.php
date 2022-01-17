<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Oil extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $table = 'oils';
    protected $fillable = ['brand_id', 'type_id', 'name', 'serial_number', 'description','price', 'quantity', 'image', 'status'];

    public function brand()
    {
        return $this->belongsTo(OilBrand::class);
    }

    public function type()
    {
        return $this->belongsTo(OilType::class);
    }
}
