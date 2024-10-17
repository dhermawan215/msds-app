<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SampleDelivery extends Model
{
    use HasFactory;

    protected $table = 'sample_deliveries';

    protected $fillable = ['sample_id', 'delivery_name', 'receipt'];
    //relation belongs to sample request
    public function sampleDeliveryBelongs(): BelongsTo
    {
        return $this->belongsTo(SampleRequest::class, 'sample_id', 'id');
    }
}
