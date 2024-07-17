<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleRequestCustomer extends Model
{
    use HasFactory;

    protected $table = 'sample_request_customers';
    protected $fillable = ['sample_id', 'customer_id', 'customer_pic', 'delivery_address', 'customer_note'];

    //relation to customer
    public function sampleCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
    //relation to sample request
    public function sampleRequestCustomer(): BelongsTo
    {
        return $this->belongsTo(SampleRequest::class, 'sample_id', 'id');
    }
}
