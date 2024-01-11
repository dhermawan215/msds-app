<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterEngineeringMeasure extends Model
{
    use HasFactory;

    protected $table = 'master_engineering_measures';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
