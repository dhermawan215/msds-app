<?php

namespace App\Repository;

use App\Models\MasterInhalation;

class InhalationRepository
{
    /**
     * store the data
     * @return eloquent
     */
    public function saveInhalation($data)
    {
        $created = MasterInhalation::create([
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
    public function detailInhalation($id)
    {
        return MasterInhalation::find($id);
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updateInhalation($request)
    {
        $update = MasterInhalation::find(\base64_decode($request->du));
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
    public function deleteInhalation($ids)
    {
        return MasterInhalation::whereIn('id', $ids)->delete();
    }
}
