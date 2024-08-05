<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleDelivery extends Model
{
    use HasFactory;

    protected $table = 'sample_deliveries';

    protected $fillable = ['sample_id', 'delivery_name', 'receipt'];
}
