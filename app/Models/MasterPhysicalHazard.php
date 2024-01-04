<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPhysicalHazard extends Model
{
    use HasFactory;

    protected $table = 'master_physical_hazards';

    protected $fillable = ['code', 'description', 'language', 'created_by', 'hscat_id'];
}
