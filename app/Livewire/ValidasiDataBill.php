<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Regs;
use App\Models\Undians;

class ValidasiDataBill extends Component
{
    public $regid = '';
    public $imgzoom = 100;
    public $statustappingbox=1;
    public $tappingboxid='';
    public $keterangan='';

    public $dataregs = []; // Tambahkan ini untuk mendefinisikan dataregs

    public $notificationType = 'error'; // 'success', 'error', or 'info'
    public $notification = '';
    public $open=false;
    
    public function render()
    {
        // Kirim data ke view
        foreach($this->dataregs as $datareg){
                return view('livewire.validasi-data-bill', ['dataregs' => $this->dataregs]);
        }
    }

    public function mount($regid)
    {
        $this->regid = $regid;
        
        // Ambil data hasil join dari database dan simpan ke properti
        $this->dataregs = DB::table('regs')
            ->leftJoin('wp_datas', 'regs.nik', '=', 'wp_datas.nik')
            ->leftJoin('merchants', 'regs.merchant_id', '=', 'merchants.id')
            ->select(
                'regs.*', 
                'wp_datas.nm_wp as nm_wp',
//                'wp_datas.alm_wp as alm_wp',
		DB::raw('CONCAT("DS.",wp_datas.desa_wp,", RT.",wp_datas.rt_wp," RW.",wp_datas.rw_wp,", KEC.",wp_datas.kecamatan_wp,", ",wp_datas.daerah_wp,", ",wp_datas.provinsi_wp) as alm_wp'),
                'wp_datas.no_hp as nohp',
                'wp_datas.email as email', 
                'merchants.nm_merchant as nm_merchant',
                'merchants.alm_merchant', 
                'regs.status_id'
            )
            ->where('regs.id', '=', $regid)
            ->get();
    }
    
    public function rulesDataBill(){
        return[
            'statustappingbox'=>'required',
            'tappingboxid'=>'required',
        ];
    }
    public function rulesKeterangan(){
        return[
            'keterangan'=>'required',
        ];
    }
    public function messages()
        {
            return [
                'required' => 'Kolom isian tidak boleh kosong.',
                'numeric' => 'Kolom isian harus berupa angka.',
                'string' => 'Kolom isian harus berupa text.',
                // Tambahkan pesan kustom lainnya jika diperlukan
            ];
        }

        public function setNotification($message, $type = 'success', $open = true)
        {
            $this->notification = $message;
            $this->notificationType = $type;
            $this->open = $open;
            $this->dispatch('notification');
        }        
        public function validasiStore()
        {
            $this->validate($this->rulesDataBill());
    
            try {
                $regdata = Regs::find($this->regid);
                
    
                if ($regdata) {
                    try{
                    $regdata->update([
                        'status_id' => '3',
                        'status_tappingbox' => $this->statustappingbox,
                        'tappingbox_id' => $this->tappingboxid,
                    ]);
                    }
                    catch(\Exception $e){
                        dd($e);
                    }
                    $cekundian=Undians::where('reg_id','=',$this->regid)->first();
                    if(empty($cekundian)){

// Ambil nomor undian terakhir untuk penomoran berikutnya
                        $lastUndian = Undians::orderBy('id', 'desc')->first();
                        $nextNumber = $lastUndian ? $lastUndian->id + 1 : 1;
        
                        // Format nomor undian dengan leading zero (misalnya 6 digit)
                        $formattedNumber = str_pad($nextNumber, 6, '0', STR_PAD_LEFT);
                        
//                       dd($formattedNumber);
                        // Simpan undian dengan nomor yang diformat
                        Undians::create([
                            'reg_id' => $this->regid,
                            'no_undian' => $formattedNumber,
                        ]);

                   
                    session()->flash('notification', [
                        'message' => 'Berhasil Menyimpan Data',
                        'type' => 'success',
                        'open' => 'true'
                    ]);
                    $this->redirectRoute('regdatas');
                    }
                    else{
                        
                        session()->flash('notification', [
                            'message' => 'Data Sudah Terdaftar dengan No Undian '.$cekundian->id,
                            'type' => 'error',
                            'open' => 'true'
                        ]);
                        $this->redirectRoute('regdatas');
                    }
                    

                    // Optionally, add a success message or handle success state
                } else {
                    // Optionally, handle the case where the record is not found
                }
            } catch (\Exception $e) {
                // Handle the exception and optionally log it
            }
        }

    public function tolakValidasi(){

        $this->validate($this->rulesKeterangan());        
            
    
            try {
                $regdata = Regs::find($this->regid);
    
                if ($regdata) {
                    $regdata->update([
                        'status_tappingbox'=>null,
			'tappingbox_id'=>null,
			'status_id' => '4',
                        'keterangan' => $this->keterangan,
                    ]);

		    $cekundian=Undians::where('reg_id','=',$this->regid)->first();
                    if(!empty($cekundian)){
                    $cekundian->delete();
                    }

                    session()->flash('notification', [
                        'message' => 'Berhasil Menyimpan Data',
                        'type' => 'success',
                        'open' => 'true'
                    ]);
                    $this->redirectRoute('regdatas');
                    }
                    
                else {
                    // Optionally, handle the case where the record is not found
                }
            } catch (\Exception $e) {
                // Handle the exception and optionally log it
            }
    }
    public function kembali(){
    
            try {
                $regdata = Regs::find($this->regid);
    
                if ($regdata) {
                    $regdata->update([
                        'status_id' => '1',
                        'keterangan' => $this->keterangan,
                    ]);

                    session()->flash('notification', [
                        'message' => 'Berhasil Kembali',
                        'type' => 'success',
                        'open' => 'true'
                    ]);
                    $this->redirectRoute('regdatas');
                    }
                    
                else {
                    // Optionally, handle the case where the record is not found
                }
            } catch (\Exception $e) {
                // Handle the exception and optionally log it
            }
    }
}
