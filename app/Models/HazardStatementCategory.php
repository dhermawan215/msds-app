<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HazardStatementCategory extends Model
{
    use HasFactory;

    protected $table = 'hazard_statement_categories';

    protected $fillable = ['category_name', 'created_by'];
}
