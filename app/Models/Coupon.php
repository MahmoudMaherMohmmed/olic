<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Coupon extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'coupons';
    protected $fillable = ['oil_id', 'coupon', 'from', 'to', 'discount', 'status'];

    public function oil()
    {
        return $this->belongsTo(Oil::class);
    }
}
