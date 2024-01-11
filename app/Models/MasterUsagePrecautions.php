<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterUsagePrecautions extends Model
{
    use HasFactory;

    protected $table = 'master_usage_precautions';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
