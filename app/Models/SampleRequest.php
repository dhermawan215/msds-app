<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class SampleRequest extends Model
{
    use HasFactory;

    protected $table = 'sample_requests';
    protected $fillable = [
        'sample_ID',
        'subject',
        'requestor',
        'required_date',
        'delivery_date',
        'delivery_by',
        'requestor_note',
        'sample_source_id',
        'sample_status',
        'sample_pic',
        'sample_pic_status',
        'sample_pic_note',
        'sample_pic_approve_at',
        'rnd',
        'rnd_status',
        'rnd_note',
        'rnd_approve_at',
        'cs',
        'cs_status',
        'cs_note',
        'cs_approve_at',
        'token',
        'token_expired_at',
    ];
    //relation to user table
    public function sampleRequestor(): BelongsTo
    {
        return $this->belongsTo(User::class, 'requestor', 'id');
    }
    //relation to sample customer
    public function sampleRequestCustomers(): HasOne
    {
        return $this->hasOne(SampleRequestCustomer::class, 'sample_id', 'id');
    }
    //relation to sample request product
    public function sampleRequestProducts(): HasMany
    {
        return $this->hasMany(SampleRequestProduct::class, 'sample_id', 'id');
    }
    //relation to sample source
    public function sampleSource(): BelongsTo
    {
        return $this->belongsTo(SampleSource::class, 'sample_source_id', 'id');
    }
}
