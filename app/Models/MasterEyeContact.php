<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterEyeContact extends Model
{
    use HasFactory;

    protected $table = 'master_eye_contacts';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
