<?php

namespace App\Repository;

use App\Models\MasterSafetyPhrases;

class SafetyPhrasesRepository
{
    /**
     * store the data
     * @return eloquent
     */
    public function saveSafetyPhrases($data)
    {
        $created = MasterSafetyPhrases::create([
            'code' => $data['code'],
            'description' => $data['description'],
            'language' => $data['language'],
            'created_by' => $data['created_by'],
        ]);
        return $created;
    }
    /**
     * detail the data
     * @param decode $id
     * @return eloquent
     */
    public function detailSafetyPhrases($id)
    {
        return MasterSafetyPhrases::select('code', 'description', 'language')
            ->where('id', $id)->first();
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updateSafetyPhrases($request)
    {
        $update = MasterSafetyPhrases::find(\base64_decode($request->du));
        $update->update([
            'code' => $request->code,
            'description' => $request->description,
            'language' => $request->language,
        ]);
        return $update;
    }
    /**
     * delete the data
     * @return eloquent
     */
    public function deleteSafetyPhrases($ids)
    {
        return MasterSafetyPhrases::whereIn('id', $ids)->delete();
    }
}
