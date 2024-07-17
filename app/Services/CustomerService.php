<?php

namespace App\Services;

use App\Models\Customer;
use App\Models\CustomerDetail;

class CustomerService
{
    /**
     * get data for dropdown customer in sample request customer detail
     */
    public function getCustomer($request)
    {
        $data = [];
        $resultCount = 20;
        $perPage = $request->page;
        $offset = ($perPage - 1) * $resultCount;
        $customer = Customer::select('id', 'customer_name');

        if ($request->search) {
            $customer->where('customer_name', 'like', '%' . $request->search . '%');
        }

        $resData = $customer->skip($offset)
            ->take($resultCount)->get();
        $recordsTotal = $resData->count();

        if ($resData->isEmpty()) {
            $data['id'] = 0;
            $data['text'] = 'empty';
            $arr[] = $data;
        }

        foreach ($resData as $key => $value) {
            $data['id'] = $value->id;
            $data['text'] = $value->customer_name;
            $arr[] = $data;
        }

        $responses = [
            'items' => $arr,
            'recordsTotal' => $recordsTotal
        ];
        return $responses;
    }
    /**
     * get value address and pic, from customer detail
     */
    public function getAddressPic($request)
    {
        $customerDetail = CustomerDetail::select('customer_pic', 'customer_address')
            ->where('customer_id', $request->customer)->get();
        $dataPic = [];
        $dataAddress = [];
        if ($customerDetail->isEmpty()) {
            $dataPic['id'] = '';
            $dataPic['text'] = 'empty';
            $dataAddress['id'] = '';
            $dataAddress['text'] = 'empty';
            $arr[] = $dataPic;
            $arr2[] = $dataAddress;
        }

        foreach ($customerDetail as $key => $value) {
            $dataPic['id'] = $value->customer_pic;
            $dataPic['text'] = $value->customer_pic;
            $dataAddress['id'] = $value->customer_address;
            $dataAddress['text'] = $value->customer_address;
            $arr[] = $dataPic;
            $arr2[] = $dataAddress;
        }

        $response = [
            'pic' => $arr,
            'address' => $arr2
        ];
        return $response;
    }
}
