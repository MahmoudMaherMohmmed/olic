<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use App\Traits\Translatable;

class OilType extends Model
{
    use HasFactory;
    use Translatable;
    use SoftDeletes;

    protected $table = 'oil_types';
    protected $fillable = ['service_id', 'title', 'description'];

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function oils()
    {
        return $this->hasMany(Oil::class);
    }
}
