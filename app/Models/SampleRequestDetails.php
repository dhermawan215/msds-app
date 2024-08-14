<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SampleRequestDetails extends Model
{
    use HasFactory;

    protected $table = 'sample_request_details';

    protected $fillable = ['sample_id', 'product_id', 'batch_number', 'netto', 'ghs'];
}
