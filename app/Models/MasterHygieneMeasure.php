<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterHygieneMeasure extends Model
{
    use HasFactory;

    protected $table = 'master_hygiene_measures';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
