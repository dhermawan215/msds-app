<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSpesificHazard extends Model
{
    use HasFactory;

    protected $table = 'master_spesific_hazards';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
