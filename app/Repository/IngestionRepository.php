<?php

namespace App\Repository;

use App\Models\MasterIngestion;

class IngestionRepository
{
    /**
     * store the data
     * @return eloquent
     */
    public function saveIngestion($data)
    {
        $created = MasterIngestion::create([
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
    public function detailIngestion($id)
    {
        return MasterIngestion::find($id);
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updateIngestion($request)
    {
        $update = MasterIngestion::find(\base64_decode($request->du));
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
    public function deleteIngestion($ids)
    {
        return MasterIngestion::whereIn('id', $ids)->delete();
    }
}
