<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleRequestProductDocument extends Model
{
    use HasFactory;
    protected $table = 'sample_request_product_documents';
    protected $fillable = ['sample_req_product_id', 'document_category', 'document_name', 'document_path'];

    //relation belongsto sample request product
    public function docBelongsSampleReqProduct(): BelongsTo
    {
        return $this->belongsTo(SampleRequestProduct::class, 'sample_req_product_id', 'id');
    }
}
