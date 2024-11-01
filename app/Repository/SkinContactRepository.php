<?php

namespace App\Repository;

use App\Models\MasterSkinContact;

class SkinContactRepository
{
    /**
     * store the data
     * @return eloquent
     */
    public function saveSkinContact($data)
    {
        $created = MasterSkinContact::create([
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
    public function detailSkinContact($id)
    {
        return MasterSkinContact::find($id);
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updateSkinContact($request)
    {
        $update = MasterSkinContact::find(\base64_decode($request->du));
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
    public function deleteSkinContact($ids)
    {
        return MasterSkinContact::whereIn('id', $ids)->delete();
    }
}
