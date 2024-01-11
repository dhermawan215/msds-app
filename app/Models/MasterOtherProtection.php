<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterOtherProtection extends Model
{
    use HasFactory;

    protected $table = 'master_other_protections';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
