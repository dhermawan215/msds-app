<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleRequestDetails extends Model
{
    use HasFactory;

    protected $table = 'sample_request_details';

    protected $fillable = ['sample_id', 'sample_req_product_id', 'product_id', 'batch_type', 'batch_number', 'product_remarks', 'released_by', 'netto', 'ghs', 'user_request_name', 'manufacture_date', 'expired_date'];
    //relation to sample request product
    public function sampleRequestProduct(): BelongsTo
    {
        return $this->belongsTo(SampleRequestProduct::class, 'sample_req_product_id', 'id');
    }
    //relation to sample request
    public function detailBelongsToSampleRequest(): BelongsTo
    {
        return $this->belongsTo(SampleRequest::class, 'sample_id', 'id');
    }
    //relation from obejct model sample request detail to object model product
    public function detailBelongsToProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
}
