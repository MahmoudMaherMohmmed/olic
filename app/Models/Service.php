<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Service extends Model
{
    use HasFactory;
    use Translatable;  

    protected $table = 'services';
    protected $fillable = ['title', 'description', 'image'];

    public function oilTypes()
    {
        return $this->hasMany(OilType::class);
    }

}
