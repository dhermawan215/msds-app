<?php

namespace App\Repository;

use App\Models\Ghs;

class GhsRepository
{
    public function storeGhs($data)
    {
        $createdGhs = Ghs::create([
            'name' => $data['name'],
            'path' => $data['path']
        ]);
        return $createdGhs;
    }
    /**
     * update with image
     */
    public function updateWithImage($data,  $ghsData)
    {
        $ghsData->update([
            'name' => $data['name'],
            'path' => $data['path']
        ]);
        return $ghsData;
    }
    /**
     * update without image
     */
    public function updateWithoutImage($data,  $ghsData)
    {
        $ghsData->update([
            'name' => $data['name'],
        ]);
        return $ghsData;
    }
    /**
     * delete data
     */
    public function destroyGhs($ids)
    {
        return Ghs::whereIn('id', $ids)->delete();
    }
}
