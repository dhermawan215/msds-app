<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHealthHazard extends Model
{
    use HasFactory;

    protected $table = 'master_health_hazards';

    protected $fillable = ['code', 'description', 'language', 'created_by', 'hscat_id'];
}
