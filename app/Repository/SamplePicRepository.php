<?php

namespace App\Repository;

use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\SampleRequest;
use App\Models\SampleRequestProduct;
use App\Models\SampleRequestCustomer;
use Illuminate\Support\Facades\Request;
use App\Repository\Interface\SamplePicInterface;

class SamplePicRepository implements SamplePicInterface
{
    /**
     * process the data for datatable
     * @return compact
     */
    public function detailOfSample($sampleId)
    {
        $sampleRequestData = SampleRequest::select('id', 'sample_ID', 'subject', 'requestor', 'required_date', 'delivery_date', 'delivery_by', 'requestor_note', 'sample_source_id', 'sample_pic_note', 'rnd_note', 'cs_note', 'token', 'token_expired_at')
            ->with(['sampleRequestor:id,name', 'sampleSource:id,name'])
            ->where('sample_ID', $sampleId)->first();
        $sampleRequestCustomer = SampleRequestCustomer::with('sampleCustomer')->where('sample_id', $sampleRequestData->id)->first();
        $sampleRequestProduct = SampleRequestProduct::with('sampleProduct')->where('sample_id', $sampleRequestData->id)->get();

        return compact('sampleRequestData', 'sampleRequestCustomer', 'sampleRequestProduct');
    }
    /**
     * method get sample data for content email when assign success
     */
    public function sampleForContentEmail($id)
    {
        $sampleRequestData = SampleRequest::select('sample_ID', 'subject', 'requestor', 'required_date', 'delivery_date', 'sample_pic_note', 'token')
            ->with('sampleRequestor:id,name,email')->where('id', $id)
            ->first();
        return $sampleRequestData;
    }
    /**
     * method update sample request when assign success
     */
    public function updateSampleWhenAssign($data = [], $id)
    {
        $updateData = SampleRequest::find($id);
        $updateData->update([
            'sample_status' => 1,
            'sample_pic_status' => 2,
            'sample_pic_note' => $data['sample_pic_note'],
            'sample_pic_approve_at' => Carbon::now(),
            'rnd' => $data['rnd'],
            'rnd_status' => 1,
            'token' => date('Ym') . Str::random(32) . date('ds'),
            'token_expired_at' => Carbon::now()->addMinutes(30)
        ]);
        return $updateData;
    }
    /**
     * method opern transaction sample request
     */
    public function openTransactionOfSampleRequest($id)
    {
        $openTransaction = SampleRequest::find($id);
        $update = $openTransaction->update([
            'sample_status' => 0,
            'sample_pic_status' => 1,
            'sample_pic_note' => \null,
            'sample_pic_approve_at' => \null,
            'rnd' => \null,
            'rnd_status' => 0,
            'token' => \null,
            'token_expired_at' => \null
        ]);

        return $openTransaction->sample_ID;
    }
}
