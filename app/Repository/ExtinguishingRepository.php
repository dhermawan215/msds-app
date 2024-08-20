<?php

namespace App\Repository;

use App\Models\MasterExtinguishingMedia;

class ExtinguishingRepository
{
    /**
     * store the data
     * @return eloquent
     */
    public function saveExtinguishing($data)
    {
        $created = MasterExtinguishingMedia::create([
            'description' => $data['description'],
            'language' => $data['language'],
            'notes' => $data['notes'],
            'created_by' => $data['created_by'],
        ]);
        return $created;
    }
    /**
     * detail the data
     * @param decode $id
     * @return eloquent
     */
    public function detailExtinguishing($id)
    {
        return MasterExtinguishingMedia::find($id);
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updateExtinguishing($request)
    {
        $update = MasterExtinguishingMedia::find(\base64_decode($request->du));
        $update->update([
            'description' => $request->description,
            'language' => $request->language,
            'notes' => $request->notes,
        ]);
        return $update;
    }
    /**
     * delete the data
     * @return eloquent
     */
    public function deleteExtinguishing($ids)
    {
        return MasterExtinguishingMedia::whereIn('id', $ids)->delete();
    }
}
