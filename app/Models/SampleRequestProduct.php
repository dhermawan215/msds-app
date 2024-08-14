<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleRequestProduct extends Model
{
    use HasFactory;
    protected $table = 'sample_request_products';
    protected $fillable = ['sample_id', 'product_id', 'qty', 'label_name', 'assign_to'];

    //relation to product
    public function sampleProduct(): BelongsTo
    {
        return $this->belongsTo(Product::class, 'product_id', 'id');
    }
    //relation to sample request
    public function sampleRequestProduct(): BelongsTo
    {
        return $this->belongsTo(SampleRequest::class, 'sample_id', 'id');
    }
    //relation to user
    public function sampleProductUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'assign_to', 'id');
    }
}
