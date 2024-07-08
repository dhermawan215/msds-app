<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleSource extends Model
{
    use HasFactory;

    protected $table = 'sample_sources';
    protected $fillable = ['name', 'address'];
}
