<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SampleSource extends Model
{
    use HasFactory;

    protected $table = 'sample_sources';
    protected $fillable = ['name', 'address'];

    //relation to sample request
    public function sampleRequestSources(): HasMany
    {
        return $this->hasMany(SampleRequest::class, 'sample_source_id', 'id');
    }
}
