<?php

namespace App\Repository;

use App\Models\MasterStoragePrecautionaryStatements;

class StoragePreRepository
{
    /**
     * method handle store process
     */
    public function save($data)
    {
        $created = MasterStoragePrecautionaryStatements::create([
            'code' => $data['code'],
            'description' => $data['description'],
            'language' => $data['language'],
            'created_by' => $data['created_by']
        ]);
        return $created;
    }
    /**
     * method handle detail
     * @return eloquent
     */
    public function showDetail($id)
    {
        return MasterStoragePrecautionaryStatements::find($id);
    }
    /**
     * update data
     */
    public function updateData($request)
    {
        $update = MasterStoragePrecautionaryStatements::find(\base64_decode($request->formValue));
        $update->update([
            'code' => $request->code,
            'description' => $request->description,
            'language' => $request->language
        ]);
        return $update;
    }
    /**
     * delete data
     */
    public function deleteData($ids)
    {
        return MasterStoragePrecautionaryStatements::whereIn('id', $ids)->delete();
    }
}
