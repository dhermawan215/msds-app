<?php

namespace App\Repository;

use App\Models\MasterPmif;

class PmifRepository
{
    //# repository of protective measures in fire
    /**
     * store the data
     * @return eloquent
     */
    public function savePmif($data)
    {
        $created = MasterPmif::create([
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
    public function detailPmif($id)
    {
        return MasterPmif::find($id);
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updatePmif($request)
    {
        $update = MasterPmif::find(\base64_decode($request->du));
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
    public function deletePmif($ids)
    {
        return MasterPmif::whereIn('id', $ids)->delete();
    }
}
