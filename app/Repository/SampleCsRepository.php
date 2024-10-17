<?php

namespace App\Repository;

use App\Models\SampleDelivery;

class SampleCsRepository
{
    /**
     * -----------------------------------
     * sample cs repository is repository for module sample request cs
     * use to be implemented repository pattern
     * to minimalize logic code and model
     * -----------------------------------
     */

    /**
     * get data information of delivery sample request
     * when the method is expedition
     * @param id
     * @return object data
     */
    public function deliveryInformation($id)
    {
        $delivery = SampleDelivery::where('sample_id', $id)->first();
        return [
            'delivery_name' => $delivery ? $delivery->delivery_name : null,
            'receipt' => $delivery ? $delivery->receipt : null,
        ];
    }
}
