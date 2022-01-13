<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class AdditionalService extends Model
{
    use HasFactory;
    use Translatable;

    protected $table = 'additional_services';
    protected $fillable = ['title', 'description', 'price', 'image'];
}
