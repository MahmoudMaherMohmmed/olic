<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClientCar extends Model
{
    use HasFactory;

    protected $table = 'client_cars';
    protected $fillable = ['client_id', 'model_id', 'cylinder_id', 'manufacture_year', 'status'];
}