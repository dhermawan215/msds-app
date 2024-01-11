<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterPmif extends Model
{
    use HasFactory;

    // model untuk data protective measures in fire

    protected $table = 'master_pmifs';

    protected $fillable = ['description', 'language', 'notes', 'created_by'];
}
