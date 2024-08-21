<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Illuminate\Support\Facades\DB;

class RegDatasExport implements FromCollection, WithHeadings
{
    protected $statusid;

    public function __construct($statusid)
    {
        $this->statusid = $statusid;
    }

    public function collection()
    {
      
        $query=DB::table('regs')
        ->leftJoin('wp_datas', 'regs.nik', '=', 'wp_datas.nik')
        ->leftJoin('merchants', 'regs.merchant_id', '=', 'merchants.id')
        ->join('statuses', 'regs.status_id', '=', 'statuses.id')
        ->leftJoin('undians', 'regs.id', '=', 'undians.reg_id')
        ->select(
            'regs.id', 
            DB::raw("CONCAT('\'', regs.nik) as nik"), 
            'wp_datas.nm_wp as nm_wp', 
            'merchants.nm_merchant as nm_merchant', 
            'statuses.reg_status', 
            'undians.id as no_undian'
        );

        if ($this->statusid > 0) {
            $query->where('regs.status_id', $this->statusid);
        }
        
        
        // Mendapatkan data dan mengembalikannya
        return $query->get();
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
