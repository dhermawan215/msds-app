<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterRiskPhrases extends Model
{
    use HasFactory;

    protected $table = 'master_risk_phrases';

    protected $fillable = ['code', 'description', 'language', 'created_by'];
}
