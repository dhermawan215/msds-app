<?php

namespace App\Repository;

use App\Models\MasterSsfp;

class SffpRepository
{
    //# repository of special fire fighting procedures
    /**
     * store the data
     * @return eloquent
     */
    public function saveSffp($data)
    {
        $created = MasterSsfp::create([
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
    public function detailSffp($id)
    {
        return MasterSsfp::find($id);
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updateSffp($request)
    {
        $update = MasterSsfp::find(\base64_decode($request->du));
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
    public function deleteSffp($ids)
    {
        return MasterSsfp::whereIn('id', $ids)->delete();
    }
}
