<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSkinContact extends Model
{
    use HasFactory;

    protected $table = 'master_ingestions';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
