<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHandProtection extends Model
{
    use HasFactory;

    protected $table = 'master_hand_protections';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
