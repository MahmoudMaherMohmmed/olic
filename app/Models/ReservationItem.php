<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ReservationItem extends Model
{
    use HasFactory;

    protected $table = 'reservation_items';
    protected $fillable = ['reservation_id','service_id', 'type'];

    public function reservation()
    {
        return $this->belongsTo(Reservation::class);
    }
}
