<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterSafetyPhrases extends Model
{
    use HasFactory;

    protected $table = 'master_safety_phrases';

    protected $fillable = ['code', 'description', 'language', 'created_by'];
}
