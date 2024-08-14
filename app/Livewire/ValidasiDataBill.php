<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;

class ValidasiDataBill extends Component
{
    public $dataregs = []; // Properti untuk menyimpan data

    public function render()
    {
        // Kirim data ke view
        return view('livewire.validasi-data-bill', ['dataregs' => $this->dataregs]);
    }

    public function mount()
    {
        // Ambil data hasil join dari database dan simpan ke properti
        $this->dataregs = DB::table('regs')
            ->leftJoin('wp_datas', 'regs.nik', '=', 'wp_datas.nik')
            ->leftJoin('merchants', 'regs.merchant_id', '=', 'merchants.id')
            ->select('regs.*', 'wp_datas.nm_wp as nm_wp', 'merchants.nm_merchant as nm_merchant', 'regs.status_id')
            ->get();
    }
}
