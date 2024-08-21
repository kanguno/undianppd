<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Regs;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegDatasExport;
class RegDatas extends Component
{
    use WithPagination;
//    public $dataregs = []; // Properti untuk menyimpan data

    public $notificationType = 'error'; // 'success', 'error', or 'info'
    public $notification = '';
    public $open=false;
    public $border='border';
    public $statusid="1";
    public $jmldata="20";
    public function render()
    {
      // Ambil data hasil join dari database dan lakukan paginasi di sini
      
      $statusid=$this->statusid;
      $jmldata=$this->jmldata;

      $query = DB::table('regs')
      ->leftJoin('wp_datas', 'regs.nik', '=', 'wp_datas.nik')
      ->leftJoin('merchants', 'regs.merchant_id', '=', 'merchants.id')
      ->join('statuses', 'regs.status_id', '=', 'statuses.id')
      ->leftJoin('undians', 'regs.id', '=', 'undians.reg_id')
      ->select('regs.*', 'wp_datas.nm_wp as nm_wp','wp_datas.no_hp as no_hp', 'merchants.nm_merchant as nm_merchant','statuses.reg_status','undians.id as no_undian');
      
      if ($statusid === '1' || $statusid === '2') {
        $query->where('regs.status_id', '<', 3);
        } else if ($statusid) {
        // Apply other conditions based on $statusid if needed
        $query->where('regs.status_id', '=', $statusid);
        }

        
      $dataregs=$query->paginate($jmldata);

  // Kirim data ke view
        return view('livewire.reg-datas', ['dataregs' => $dataregs]);
    }

    public function setNotification($message, $type = 'success', $open = true)
    {
        $this->notification = $message;
        $this->notificationType = $type;
        $this->open = $open;
        $this->dispatch('notification');
    } 

    public function ValidasiData($regid){
        
        $datareg=Regs::find($regid);
        if($datareg->status_id===2){
            session()->flash('notification', [
                'message' => 'Data sedang divalidasi',
                'type' => 'warning',
                'open' => 'true'
            ]);
            $this->redirectRoute('regdatas');
            }
            else{
            $datareg->update([
                'status_id'=>'2'
            ]);
            $this->redirectRoute('validasidata', $regid);
            }
    }

    public function resetValidasi($regid){
        $datareg=Regs::find($regid);
        
            $datareg->update([
                'status_id'=>'1'
            ]);
            session()->flash('notification', [
                'message' => 'Berhasil Reset Status',
                'type' => 'warning',
                'open' => 'true'
            ]);
            $this->redirectRoute('regdatas');
    }

    public function KirimData($regid,$statusid){
        $query = DB::table('regs')
        ->leftJoin('wp_datas', 'regs.nik', '=', 'wp_datas.nik')
        ->leftJoin('undians', 'regs.id', '=', 'undians.reg_id')
        ->select('regs.*', 'wp_datas.nm_wp as nm_wp', 'wp_datas.no_hp as no_hp', 'undians.id as no_undian')
        ->where('regs.id', '=', $regid)
        ->first(); // Menambahkan first() untuk mendapatkan hasil query

    $nohp='62'.substr($query->no_hp, 1);
    if($statusid==='3'){
    $pesan='Hallo *'.$query->nm_wp.'* Selamat Anda Terdaftar sebagai peserta Gebyar Undian Pajak Daerah Tuban 2024 dengan nomor undian *'.$query->no_undian.'*';
    }
    elseif($statusid==='4'){
    $pesan='Hallo *'.$query->nm_wp.'* Mohon maaf, permohonan undian anda kami tolak karena *'.$query->keterangan.'*';
    }
    $pesan=str_replace(' ', '%20', $pesan);
    
    $url = 'https://web.whatsapp.com/send?phone='.$nohp.'&text='.$pesan; // URL yang benar
    \Log::info('Redirecting to URL:', ['url' => $url]); // Log URL
    $this->dispatch('redirect', url:$url);


    }

    public function exportData($statusid)
    {
     
        // Buat file sementara
        if ($statusid=='0') {
            
           
            return Excel::download(new RegDatasExport($statusid), 'regs.xlsx');
        }
    }
    
}


