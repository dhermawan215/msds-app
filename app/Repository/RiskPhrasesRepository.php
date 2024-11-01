<?php

namespace App\Repository;

use App\Models\MasterRiskPhrases;

class RiskPhrasesRepository
{
    /**
     * store the data
     * @return eloquent
     */
    public function saveRiskPhrases($data)
    {
        $created = MasterRiskPhrases::create([
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
    public function detailRiskPhrases($id)
    {
        return MasterRiskPhrases::select('code', 'description', 'language')
            ->where('id', $id)->first();
    }
    /**
     * update the data
     * @param request
     * @return eloquent
     */
    public function updateRiskPhrases($request)
    {
        $update = MasterRiskPhrases::find(\base64_decode($request->du));
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
    public function deleteRiskPhrases($ids)
    {
        return MasterRiskPhrases::whereIn('id', $ids)->delete();
    }
}
