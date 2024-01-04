<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterInhalation extends Model
{
    use HasFactory;

    protected $table = 'master_inhalations';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
