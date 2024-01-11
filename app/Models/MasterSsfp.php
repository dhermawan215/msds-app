<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSsfp extends Model
{
    use HasFactory;

    // model untuk data special fire fighting procedures

    protected $table = 'master_ssfps';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
