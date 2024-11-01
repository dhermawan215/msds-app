<?php

namespace App\Repository;

use App\Models\SampleDelivery;
use Carbon\Carbon;
use Illuminate\Support\Str;
use App\Models\SampleRequest;
use App\Models\SampleRequestProduct;
use App\Models\SampleRequestCustomer;
use App\Models\SampleSource;
use App\Models\User;
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
        $sampleRequestData = SampleRequest::select('id', 'sample_ID', 'subject', 'requestor', 'request_date', 'delivery_date', 'delivery_by', 'requestor_note', 'sample_source_id', 'sample_pic_note', 'rnd_note', 'cs_note', 'token', 'token_expired_at')
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
        $sampleRequestData = SampleRequest::select('sample_ID', 'subject', 'requestor', 'request_date', 'delivery_date', 'sample_pic_note', 'token')
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
    /**
     * method get sample data for change request
     */
    public function sampleForChangeStatus($sampleId)
    {
        $sampleRequest = SampleRequest::select('sample_ID', 'subject', 'delivery_by', 'sample_status')
            ->where('sample_ID', $sampleId)->first();

        return $sampleRequest;
    }
    /**
     * method get data sample deliveries
     * @return data delivery or empty data
     */
    public function getSampleDelivery($idSampleRequest)
    {
        $sampleDelivery = SampleDelivery::where('sample_id', $idSampleRequest)->first();

        $data = [
            'delivery_name' => $sampleDelivery ? $sampleDelivery->delivery_name : 'empty data',
            'receipt' => $sampleDelivery ? $sampleDelivery->receipt : 'empty data',
        ];
        return $data;
    }
    /**
     * change status sample from ready to pickup
     */
    public function updateWhenChangeStatus($data, $sampleID)
    {
        $sampleRequestChangeStatus = SampleRequest::where('sample_ID', $sampleID);
        $sampleRequestChangeStatus->update([
            'sample_status' => $data['sample_status'],
            'sample_pic_note' => $data['sample_pic_note'],
            'cs_status' => $data['cs_status'],
            'token' => $data['token'],
            'token_expired_at' => $data['token_expired_at']
        ]);

        return $sampleRequestChangeStatus;
    }
    /**
     * get qty sample product when null (before assign)
     */
    public function countUnSignSampleProduct($sampleId)
    {
        $sampleProduct = SampleRequestProduct::where('sample_id', $sampleId);
        $sampleProductCollection = $sampleProduct->get();
        if (!$sampleProductCollection->isEmpty()) {
            $query = $sampleProduct->where(function ($q) {
                $q->whereNull('assign_to')
                    ->where('finished', 0);
            });
            return $query->count();
        }
        return 'false';
    }
    /**
     * get sample id
     * @param sampleID
     */
    public function getSampleId($sampleID)
    {
        return SampleRequest::select('id', 'sample_ID')->where('sample_ID', $sampleID)->first();
    }
    /**
     * assign sample product
     * @param request
     */
    public function assignSampleProduct($request)
    {
        $sampleProduct = SampleRequestProduct::find(\base64_decode($request->as))
            ->update([
                'assign_to' => $request->user
            ]);

        return $sampleProduct;
    }
    /**
     * get information sample assign to
     * @param json decode
     */
    public function getInformationSampleAssign($id)
    {
        $sampleAssignTo = SampleRequestProduct::with('sampleProductUser')
            ->where('id', $id)->first();
        return $sampleAssignTo;
    }
    /**
     * get information user assign in sample product
     */
    public function getUserInSampleProduct($id)
    {
        $userSampleProduct = SampleRequestProduct::with('sampleProductUser:id,name,email')
            ->where('sample_id', $id)->get();
        return $userSampleProduct;
    }
    /**
     * get user customer service
     */
    public function getUserCustomerService()
    {
        $user = User::whereHas('userGroup', function ($query) {
            $query->where('name', 'CUSTOMER_SERVICE');
        })->get();

        return $user;
    }
    /**
     * update sample request when sample pic change status to pickup
     */
    public function updateSampleRequestWhenChangeStatus($data): void
    {
        $sampleRequest = SampleRequest::where('sample_ID', $data['sample_ID'])->first();
        $sampleRequest->update([
            'sample_status' => $data['sample_status'],
            'sample_pic_note' => $data['sample_pic_note'],
            'cs' => $data['cs'],
            'cs_status' => $data['cs_status'],
            'token' => date('Ym') . Str::random(32) . date('ds'),
            'token_expired_at' => Carbon::now()->addMinutes(30)
        ]);
    }
}
