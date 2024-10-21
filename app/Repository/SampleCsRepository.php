<?php

namespace App\Repository;

use Carbon\Carbon;
use App\Models\SampleRequest;
use App\Models\SampleDelivery;
use App\Models\SampleRequestProduct;
use App\Models\SampleRequestCustomer;

class SampleCsRepository
{
    /**
     * -----------------------------------
     * sample cs repository is repository for module sample request cs
     * use to be implemented repository pattern
     * to minimalize logic code and model
     * -----------------------------------
     */

    /**
     * get data information of delivery sample request
     * when the method is expedition
     * @param id
     * @return object data
     */
    public function deliveryInformation($id): array
    {
        $delivery = SampleDelivery::where('sample_id', $id)->first();
        return [
            'delivery_name' => $delivery ? $delivery->delivery_name : null,
            'receipt' => $delivery ? $delivery->receipt : null,
        ];
    }
    /**
     * store the delivery information to database
     * @param array
     * @return eloquent
     */
    public function storeDelivery($data)
    {
        $sampleDelivery = SampleDelivery::create([
            'sample_id' => $data['sample'],
            'delivery_name' => $data['delivery_name'],
            'receipt' => $data['receipt'],
        ]);
        return $sampleDelivery;
    }
    /**
     * update status cs sample request
     * @param array
     */
    public function updateCsStatus($data): void
    {
        $sampleRequest = SampleRequest::find($data['sample']);
        $sampleRequest->update([
            'cs_status' => 2,
            'cs_approve_at' => Carbon::now(),
            'cs_note' => $data['cs_note']
        ]);
    }
    /**
     * sample fore content email
     * @return eloquent
     */
    public function contentEmail($id)
    {
        return SampleRequest::select('sample_ID', 'subject', 'requestor', 'request_date', 'delivery_date', 'cs_note')->with('sampleRequestor:id,name,email')->where('id', $id)->first();
    }
    /**
     * get data sample request, sample request product and customer to be shown in detail page
     * @return compact
     */
    public function detailOfSample($sampleId)
    {
        $sampleRequestData = SampleRequest::select('id', 'sample_ID', 'subject', 'requestor', 'request_date', 'delivery_date', 'delivery_by', 'requestor_note', 'sample_source_id', 'sample_pic_note', 'rnd_note', 'cs_note')
            ->with(['sampleRequestor:id,name', 'sampleSource:id,name'])
            ->where('sample_ID', $sampleId)->first();
        $sampleRequestCustomer = SampleRequestCustomer::with('sampleCustomer')->where('sample_id', $sampleRequestData->id)->first();
        $sampleRequestProduct = SampleRequestProduct::with('sampleProduct')->where('sample_id', $sampleRequestData->id)->get();

        return compact('sampleRequestData', 'sampleRequestCustomer', 'sampleRequestProduct');
    }
}
