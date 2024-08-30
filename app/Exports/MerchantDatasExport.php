<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use App\Models\Merchants;

class MerchantDatasExport implements FromCollection
{
    /**
    * @return \Illuminate\Support\Collection
    */
    public function collection()
    {
        $data=Merchants::all();
        
        return $data;
        //
    }
    public function headings(): array
    {
        return [
            'ID',
            'NIK',
            'Nama WP',
            'Nama Merchant',
            'Status',
            'No Undian'
        ];
    }
}
