<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterExtinguishingMedia extends Model
{
    use HasFactory;

    protected $table = 'master_extinguishing_media';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
