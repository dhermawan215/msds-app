<?php

namespace App\Repository;

use App\Models\Ghs;
use App\Models\SampleRequest;
use Illuminate\Support\Facades\DB;
use App\Models\SampleRequestDetails;
use App\Models\SampleRequestProduct;
use App\Models\SampleRequestCustomer;

class SampleRndRepository
{
    /**
     * get detail of sample request
     * data sample request, sample request customer, sample request product
     * @param $sampleId
     * @return compact to view
     */
    public function getDetailOfSample($sampleId)
    {
        $sampleRequestData = SampleRequest::select('id', 'sample_ID', 'subject', 'requestor', 'request_date', 'delivery_date', 'delivery_by', 'requestor_note', 'sample_source_id', 'sample_pic_note', 'rnd_note', 'cs_note', 'token', 'token_expired_at')
            ->with(['sampleRequestor:id,name', 'sampleSource:id,name'])
            ->where('sample_ID', $sampleId)->first();
        $sampleRequestCustomer = SampleRequestCustomer::with('sampleCustomer')->where('sample_id', $sampleRequestData->id)->first();
        $sampleRequestProduct = SampleRequestProduct::with('sampleProduct')->where('sample_id', $sampleRequestData->id)->get();

        return compact('sampleRequestData', 'sampleRequestCustomer', 'sampleRequestProduct');
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
     * get count from table sample request detail,
     * to the check data availablity ghs/batch number
     */
    public function getCountSampleRequestDetails($sampleId, $productId)
    {
        $sampleRequestDetail = SampleRequestDetails::where('sample_id', $sampleId)->where('product_id', $productId);
        return $sampleRequestDetail->count();
    }
    /**
     * get data ghs for dropdown
     */
    public function getGhsDropdown($request)
    {
        $data = [];
        $resultCount = 20;
        $perPage = $request->page;
        $offset = ($perPage - 1) * $resultCount;
        $product = Ghs::select('id', 'name', 'path');

        if ($request->search) {
            $product->where('name', 'like', '%' . $request->search . '%');
        }

        $resData = $product->skip($offset)
            ->take($resultCount)->get();
        $recordsTotal = $resData->count();

        if ($resData->isEmpty()) {
            $data['id'] = 0;
            $data['text'] = 'empty';
            $data['path'] = null;
            $arr[] = $data;
        }

        foreach ($resData as $key => $value) {
            $data['id'] = $value->id;
            $data['text'] = $value->name;
            $data['path'] = \asset($value->path);
            $arr[] = $data;
        }

        $responses = [
            'items' => $arr,
            'recordsTotal' => $recordsTotal
        ];
        return $responses;
    }
    /**
     * get sample request batch
     */
    public function getBatchNumber()
    {
        $batchNo = SampleRequestDetails::select('id', 'batch_number')
            ->where('batch_type', 'LAB')
            ->where('id', function ($query) {
                $query->select(DB::raw('MAX(id)'))->from('sample_request_details')
                    ->where('batch_type', 'LAB');;
            })
            ->first();

        return $batchNo;
    }
    /**
     * store sample request detail
     */
    public function storeSampleDetail($data): void
    {
        SampleRequestDetails::create([
            'sample_id' => \base64_decode($data['srVal']),
            'sample_req_product_id' => \base64_decode($data['srpVal']),
            'product_id' => \base64_decode($data['prVal']),
            'batch_type' => $data['batch_type'],
            'batch_number' => $data['batch_number'],
            'product_remarks' => $data['product_remarks'],
            'released_by' => $data['released_by'],
            'ghs' => \json_encode($data['ghs']),
            'user_request_name' => $data['requestor'],
            'manufacture_date' => $data['manufacture_date'],
            'expired_date' => $data['expired_date']
        ]);
    }
    /**
     * get user name (requestor) for lable sample request detail(sticker)
     */
    public function getRequestorSampleRequest($sample_id)
    {
        $sampleRequest = SampleRequest::select('id', 'sample_ID', 'requestor')->with('sampleRequestor:id,name,email')->where('id', $sample_id)->first();
        return $sampleRequest;
    }
    /**
     * when user click button finish, repository can update the data sample request product
     */
    public function finishedSampleProduct($id): void
    {
        $finished = SampleRequestProduct::find(\base64_decode($id));
        $finished->update(['finished' => 1]);
    }
}
