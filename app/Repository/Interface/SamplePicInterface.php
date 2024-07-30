<?php

namespace App\Repository\Interface;

use Illuminate\Support\Facades\Request;

interface SamplePicInterface
{
    public function detailOfSample($sampleId);

    // public function changeStatus(Request $request);

    public function sampleForContentEmail($id);
}
