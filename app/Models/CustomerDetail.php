<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CustomerDetail extends Model
{
    use HasFactory;

    protected $table = 'customer_details';
    protected $fillable = ['customer_id', 'customer_pic', 'customer_phone', 'customer_address'];
    //relation to customer
    public function detailCustomer(): BelongsTo
    {
        return $this->belongsTo(Customer::class, 'customer_id', 'id');
    }
}
