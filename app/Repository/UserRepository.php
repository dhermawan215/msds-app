<?php

namespace App\Repository;

use App\Models\User;
use Illuminate\Support\Facades\Request;

class UserRepository
{
    public function getListofUser($request)
    {
        $data = [];
        $resultCount = 20;
        $perPage = $request->page;
        $offset = ($perPage - 1) * $resultCount;
        $customer = User::select('id', 'name');

        if ($request->search) {
            $customer->where('name', 'like', '%' . $request->search . '%');
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
            $data['text'] = $value->name;
            $arr[] = $data;
        }

        $responses = [
            'items' => $arr,
            'recordsTotal' => $recordsTotal
        ];
        return $responses;
    }
    /**
     * get user data form sample assign
     */
    public function getUserSampleAssign($id)
    {
        $user = User::select('id', 'name', 'email')->whereIn('id', $id)->get();
        return $user;
    }
}
