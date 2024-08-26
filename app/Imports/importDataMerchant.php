<?php

namespace App\Imports;

use App\Models\Merchants;
use Maatwebsite\Excel\Concerns\ToModel;

class importDataMerchant implements ToModel
{
    /**
    * @param array $row
    *
    * @return \Illuminate\Database\Eloquent\Model|null
    */
    public function model(array $row)
    {
        return new Merchants([
            //
            'device_id' => $row[0],
            'nopd' => $row[1],
            'nm_merchant' => $row[2],
            'alm_merchant' => $row[3],
            'created_at' => $row[4],
            'updated_at' => $row[5],
        ]);
    }
}
