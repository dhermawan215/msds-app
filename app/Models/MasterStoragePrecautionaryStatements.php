<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MasterStoragePrecautionaryStatements extends Model
{
    use HasFactory;

    protected $table = 'master_storage_precautionary_statements';

    protected $fillable = ['code', 'description', 'language', 'created_by'];
}
