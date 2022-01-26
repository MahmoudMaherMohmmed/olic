<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SupplyItem extends Model
{
    use HasFactory;

    protected $table = 'supply_items';
    protected $fillable = ['supply_id', 'oil_id', 'quantity'];

    public function supply()
    {
        return $this->belongsTo(Supply::class);
    }
}
