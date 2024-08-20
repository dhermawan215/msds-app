<?php

namespace App\Repository;

use App\Models\MasterEyeContact;

class EyeContactRepository
{
    /**
     * store the data
     * @return eloquent
     */
    public function saveEyeContact($data)
    {
        $created = MasterEyeContact::create([
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
    public function detailEyeContact($id)
    {
        return MasterEyeContact::find($id);
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updateEyeContact($request)
    {
        $update = MasterEyeContact::find(\base64_decode($request->du));
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
    public function deleteEyeContact($ids)
    {
        return MasterEyeContact::whereIn('id', $ids)->delete();
    }
}
