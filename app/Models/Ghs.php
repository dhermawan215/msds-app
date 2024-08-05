<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Ghs extends Model
{
    use HasFactory;

    protected $table = 'ghs';

    protected $fillable = ['name', 'path'];
}
