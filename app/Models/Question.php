<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Traits\Translatable;

class Question extends Model
{
    use HasFactory;
    use Translatable;

    protected $table = 'questions';
    protected $fillable = ['question', 'answer', 'status'];
}
