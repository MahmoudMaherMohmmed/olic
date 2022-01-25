<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Supplier extends Model
{
    use HasFactory;
    use SoftDeletes;

    protected $table = 'suppliers';
    protected $fillable = ['name', 'email', 'phone', 'phone_2', 'image'];

    public function supplies()
    {
        return $this->hasMany(Supply::class);
    }
}
