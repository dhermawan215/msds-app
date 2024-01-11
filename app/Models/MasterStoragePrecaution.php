<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStoragePrecaution extends Model
{
    use HasFactory;

    protected $table = 'master_storage_precautions';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
