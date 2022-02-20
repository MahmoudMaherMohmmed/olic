<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class FreeService extends Model
{
    use HasFactory;
    use Translatable; 

    protected $table = 'free_services';
    protected $fillable = ['title', 'description', 'model_id', 'cylinder_id', 'manufacture_year', 'image'];
}
