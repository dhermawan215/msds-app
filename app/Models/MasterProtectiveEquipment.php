<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterProtectiveEquipment extends Model
{
    use HasFactory;

    protected $table = 'master_protective_equipment';

    protected $fillable = ['name', 'image_path', 'created_by'];
}
