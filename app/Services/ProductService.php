<?php

namespace App\Services;

use App\Models\Product;

class ProductService
{
    /**
     * get product value for dropdown in sample request product
     */
    public function getProduct($request)
    {
        $data = [];
        $resultCount = 20;
        $perPage = $request->page;
        $offset = ($perPage - 1) * $resultCount;
        $product = Product::select('id', 'product_code', 'product_function');

        if ($request->search) {
            $product->where('product_code', 'like', '%' . $request->search . '%')
                ->orWhere('product_function', 'like', '%' . $request->search . '%');
        }

        $resData = $product->skip($offset)
            ->take($resultCount)->get();
        $recordsTotal = $resData->count();

        if ($resData->isEmpty()) {
            $data['id'] = 0;
            $data['text'] = 'empty';
            $arr[] = $data;
        }

        foreach ($resData as $key => $value) {
            $data['id'] = $value->id;
            $data['text'] = $value->product_code . '-' . $value->product_function;
            $arr[] = $data;
        }

        $responses = [
            'items' => $arr,
            'recordsTotal' => $recordsTotal
        ];
        return $responses;
    }
}
