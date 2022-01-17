<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Translatable;

class OilBrand extends Model
{
    use HasFactory; 
    use SoftDeletes;
    use Translatable;

    protected $table = 'oil_brands';
    protected $fillable = ['title', 'description', 'image'];

    public function oils()
    {
        return $this->hasMany(Oil::class);
    }
}
