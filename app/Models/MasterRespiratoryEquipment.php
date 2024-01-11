<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRespiratoryEquipment extends Model
{
    use HasFactory;

    protected $table = 'master_respiratory_equipment';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
