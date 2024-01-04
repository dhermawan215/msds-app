<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterEnvironmentalHazard extends Model
{
    use HasFactory;
    protected $table = 'master_environmental_hazards';

    protected $fillable = ['code', 'description', 'language', 'created_by', 'hazard_statement_id'];
}
