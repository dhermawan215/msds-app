<?php

namespace App\Repository;

use App\Models\SampleRequest;
use App\Models\SampleRequestCustomer;

class SampleRequestSalesRepository
{

    /**
     * get sample id
     * @param sample_ID
     * @return sample_id
     */
    public function getSampleId($sample_ID)
    {
        $sampleId = SampleRequest::select('id')->where('sample_ID', $sample_ID)
            ->first();
        return $sampleId;
    }
    /**
     * get information of customer information include relation
     * @param sampleID number of sample request
     * @return $sampleCustomer as eloquent
     */
    public function sampleCustomerInfo($sample_ID)
    {
        $sampleCustomer = SampleRequestCustomer::with('sampleCustomer')->whereHas('sampleRequestCustomer', function ($query) use ($sample_ID) {
            $query->where('sample_ID', $sample_ID);
        })->first();

        return $sampleCustomer;
    }
    /**
     * update sample request customer
     */
    public function updateSc($data): void
    {
        $sampleCustomer = SampleRequestCustomer::find($data['id']);
        $sampleCustomer->update([
            'customer_id' => $data['customer_id'],
            'customer_pic' => $data['customer_pic'],
            'delivery_address' => $data['delivery_address']
        ]);
    }
}
