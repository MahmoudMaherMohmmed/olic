<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Reservation extends Model
{
    use HasFactory;

    protected $table = 'reservations';
    protected $fillable = ['client_id','technician_id', 'date', 'from', 'to', 'coupon', 'total_price', 'payment_type', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function technician()
    {
        return $this->belongsTo(Trip::class);
    }

    public function bankTransfer()
    {
        return $this->hasOne(BankTransfer::class);
    }
}
