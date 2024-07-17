<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Customer extends Model
{
    use HasFactory;
    protected $table = 'customers';
    protected $fillable = ['customer_code', 'customer_name', 'user_id', 'customer_registered_at'];

    //relation to user model
    public function customerUser(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
    //relation to customer detail
    public function customerDetails(): HasMany
    {
        return $this->hasMany(CustomerDetail::class, 'customer_id', 'id');
    }
    //relation to sample customer
    public function customerSamples(): HasMany
    {
        return $this->hasMany(SampleRequestCustomer::class, 'customer_id', 'id');
    }
}
