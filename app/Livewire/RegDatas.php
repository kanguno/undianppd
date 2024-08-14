<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use Livewire\WithPagination;
class RegDatas extends Component
{
    use WithPagination;
//    public $dataregs = []; // Properti untuk menyimpan data

    public function render()
    {
      // Ambil data hasil join dari database dan lakukan paginasi di sini
      $dataregs = DB::table('regs')
      ->leftJoin('wp_datas', 'regs.nik', '=', 'wp_datas.nik')
      ->leftJoin('merchants', 'regs.merchant_id', '=', 'merchants.id')
      ->join('statuses', 'regs.status_id', '=', 'statuses.id')
      ->select('regs.*', 'wp_datas.nm_wp as nm_wp', 'merchants.nm_merchant as nm_merchant', 'statuses.reg_status')
      ->paginate(10);

  // Kirim data ke view
  return view('livewire.reg-datas', ['dataregs' => $dataregs]);
    }

    
}


