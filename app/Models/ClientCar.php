<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ClientCar extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'client_cars';
    protected $fillable = ['client_id', 'model_id', 'cylinder_id', 'manufacture_year', 'status'];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function model()
    {
        return $this->belongsTo(CarModel::class);
    }

    public function cylinder()
    {
        return $this->belongsTo(CarCylinder::class);
    }

    public function reservations()
    {
        return $this->hasMany(Reservation::class);
    }
}
