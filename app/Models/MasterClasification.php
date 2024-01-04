<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterClasification extends Model
{
    use HasFactory;

    protected $table = 'master_clasifications';

    protected $fillable = ['code', 'description', 'language', 'created_by'];
}
