<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class PrecautionaryStatementCategory extends Model
{
    use HasFactory;

    protected $table = 'precautionary_statement_categories';

    protected $fillable = ['category_name', 'created_by'];
}
