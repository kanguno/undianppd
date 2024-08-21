<?php

namespace App\Livewire;
use Livewire\WithFileUploads;
use Livewire\Attributes\Validate;
use Livewire\Component;
use App\Models\wpdatas;
use App\Models\Regs;
use App\Models\Merchants;
use Illuminate\Support\Str;
class InputDataBill extends Component
{
    use WithFileUploads;
    public $formstatus=0;
    public $display='';
    public $readonly='';
    
    public $nik = '';
    public $nama = '';
    public $alamat = '';
    public $nohp = '';
    public $email = '';
    public $pesan = ''; 
    public $merchant='';
    public $merchants='';
    public $tglbill = '';
    public $jambill = '';
    public $photo = '';
    public $isFound = false;
    public $showmessage=false;
    public $notificationType = 'error'; // 'success', 'error', or 'info'
    public $notification = '';
    public $open=false;
    
    
    public function render()
    {
        $this->dispatch('wire:load');
        \Log::info('Current NIK: ' . $this->nik); // Log data NIK
        return view('livewire.input-data-bill')
        ->extends('layouts.front');
    }
    public function mount(){
        $this->merchants=Merchants::All();
        //$this->notification="Uji Coba";
        //dd($this->merchants);
        // $this->setNotification('Isikan Data Anda dan Data Transaksi Anda dengan Sesuai','info');
    }
    public function rulesForNik()
    {
        return [
            'nik' => 'required|digits:16|numeric',
        ];
    }
    public function rulesDataWp(){
        return[
            'nama'=>'required|string|max:255',
            'alamat'=>'required|string|max:500',
            'nohp'=>'required|numeric',
            'email'=>'required|string|max:255',
            ];
    }
    public function rulesDataBill(){
        return[
            'photo'=>'required|image|mimes:jpeg,png,jpg|max:1024',
            'tglbill'=>'required',
            'jambill'=>'required',
            'merchant'=>'required',
        ];
    }
    public function messages()
        {
            return [
                'required' => 'Kolom isian tidak boleh kosong.',
                'nik.digits' => 'NIK harus terdiri dari 16 digit.',
                'numeric' => 'Kolom isian harus berupa angka.',
                'string' => 'Kolom isian harus berupa text.',
                'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
                'alamat.max' => 'Alamat tidak boleh lebih dari 500 karakter.',
                'image' => 'File yang diupload harus berupa gambar',
                'mimes' => 'File yang diupload harus format JPG/PNG/JPEG',
                'photo.max' => 'Ukuran File yang diupload maksimal 1 MB',
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

        
        private function maskData($data, $visibleLength = 2) {
            if (empty($data)) {
                return $data;
            }
        
            // Pisahkan string menjadi kata-kata
            $words = explode(' ', $data);
            $maskedWords = [];
        
            foreach ($words as $word) {
                if (strlen($word) <= $visibleLength) {
                    // Jika kata lebih pendek atau sama dengan panjang yang terlihat, mask seluruh kata
                    $maskedWords[] = str_repeat('x', strlen($word));
                } else {
                    // Mask semua karakter kecuali yang terlihat
                    $visible = substr($word, 0, $visibleLength);
                    $masked = str_repeat('x', strlen($word) - $visibleLength);
                    $maskedWords[] = $visible . $masked;
                }
            }
        
            return implode(' ', $maskedWords);
        }

    public function ceknik(){
        $this->showmessage=true;
        $this->isFound=false;
        $this->validate($this->rulesForNik());
        $data=wpdatas::where('nik',$this->nik)->first();
        
    if($data){
        $this->isFound=true;
        $this->nama=$data->nm_wp;
        $this->alamat=$data->alm_wp;
        $this->nohp=$data->no_hp;
        $this->email=$data->email;
        //$this->setNotification('Isikan Data Anda dan Data Transaksi Anda dengan Sesuai','info');
        $this->pesan='NIK Terdaftar Atas Nama '.$this->maskData($this->nama).' dengan nik '.$this->nik;
        $this->display='hidden';

    }
    else{
        $this->isFound=false;
        $this->pesan='NIK Tidak Terdaftar';
        $this->display='hidden';
        }
    }

    public function regbaru(){
       $this->showmessage=false;
       $this->formstatus=1;
    }

    public function tambahreg(){
       // $this->setNotification('Berhasil Menyimpan Data', 'success');
        $this->showmessage=false;
        $this->formstatus=1;
        $this->nama=$this->maskData($this->nama);
        $this->alamat=$this->maskData($this->alamat);
        $this->nohp=$this->maskData($this->nohp);
        $this->email=$this->maskData($this->email);
        $this->readonly="readonly";
    }

    public function regSave(){
        
        $nik=$this->nik;
        

        $data=wpdatas::where('nik',$this->nik)->first();
        if(empty($data)){
        $nama=Str::upper($this->nama);
        $alamat=Str::upper($this->alamat);
        $nohp=Str::upper($this->nohp);
        $email=Str::upper($this->email);
        $this->validate($this->rulesDataWp());
            wpdatas::create([
                'nik' => $nik,
                'nm_wp' => $nama,
                'alm_wp' => $alamat,
                'no_hp' => $nohp,
                'email' => $email,
            ]);
        }

        $this->validate($this->rulesDataBill());

        $filename=null;
        $merchant=$this->merchant;
        $tglbill=$this->tglbill.' '.$this->jambill;
        
        $datareg=Regs::where('merchant_id',$merchant)
                       ->where('tgl_bill',$tglbill)
                       ->where('status_id','<','4')
                       ->first();
                        // dd($datareg);
                       if (!empty($datareg)) {
                        $this->setNotification('Data Transaksi Sudah Pernah Didaftarkan, Mohon Periksa Kembali Isian Anda', 'error');
                        // dd($this->notificationType);
                    } else {
                        // Menyimpan foto jika ada
                        if ($this->photo) {
                            $safeTglbill = str_replace(['/', ':', ' ', '.'], '_', $tglbill);
                            $filename = $this->nik . '-' . $safeTglbill . '.' .time().'-'. $this->photo->getClientOriginalExtension();
                            $this->photo->storeAs('photos', $filename, 'public');
                        }
                
                        // Menyimpan data transaksi
                        Regs::create([
                            'nik' => $this->nik,
                            'merchant_id' => $merchant,
                            'bill_img' => $filename,
                            'tgl_bill' => $tglbill,
                            'status_id' => 1, // Asumsi status_id yang digunakan adalah 1
                        ]);
                
                        $this->setNotification('Berhasil Menyimpan Data', 'success');
                        return redirect()->route('inputDataBill');
                    }
    }

}
