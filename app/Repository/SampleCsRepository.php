<?php

namespace App\Repository;

use App\Models\SampleDelivery;
use App\Models\SampleRequest;
use Carbon\Carbon;

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
}
