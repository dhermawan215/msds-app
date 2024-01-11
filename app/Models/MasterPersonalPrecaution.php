<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPersonalPrecaution extends Model
{
    use HasFactory;

    protected $table = 'master_personal_precautions';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
