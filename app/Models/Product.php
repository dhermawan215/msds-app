<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';

    protected $fillable = ['product_code', 'product_name', 'product_function', 'product_application', 'created_by'];
    //relation one to many (product->sample request product)
    public function products(): HasMany
    {
        return $this->hasMany(SampleRequestProduct::class, 'product_id', 'id');
    }
    //relation from object model product to sample request detail
    public function productToSampleReqDetails(): HasMany
    {
        return $this->hasMany(SampleRequestDetails::class, 'product_id', 'id');
    }
}
