<?php

namespace App\Repository;

use App\Models\MasterSpesificHazard;

class SpesificHazardRepository
{
    //# repository of spesific hazard
    /**
     * store the data
     * @return eloquent
     */
    public function saveSH($data)
    {
        $created = MasterSpesificHazard::create([
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
    public function detailSH($id)
    {
        return MasterSpesificHazard::find($id);
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updateSH($request)
    {
        $update = MasterSpesificHazard::find(\base64_decode($request->du));
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
    public function deleteSH($ids)
    {
        return MasterSpesificHazard::whereIn('id', $ids)->delete();
    }
}
