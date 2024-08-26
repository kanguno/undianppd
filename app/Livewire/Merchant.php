<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\DB;
use App\Models\Merchants;
use Livewire\WithPagination;
use Livewire\WithFileUploads;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\MerchantDatasExport;
use App\Imports\importDataMerchant;
use Illuminate\Support\Str;

class Merchant extends Component
{
    use WithFileUploads;
    public $notificationType = 'error'; // 'success', 'error', or 'info'
    public $notification = '';
    public $modalinfo = '';
    public $modalopen = false;
    public $open=false;
    public $modalid='';

    public $namamerchant='';
    public $almmerchant='';
    public $deviceid='';
    public $nopd='';
    public $jmldata="20";
    public $hidden='hidden';
    public $tablehidden='';
    public $wiresubmit='';
    public $fileexcel='';

    public function render()
    {
        $jmldata=$this->jmldata;
        $datamerchants=Merchants::paginate($jmldata);
        return view('livewire.merchants',['datamerchants' => $datamerchants])->layout('layouts.app');;
    }    
    public function setNotification($message, $type, $open=true)
    {
        $this->notification = $message;
        $this->notificationType = $type;
        $this->open = $open;
    }       
    public function setModal($modalmessage, $type,$modalid, $modalopen=true)
    {   
        $this->modalid = $modalid;
        $this->modalinfo = $modalmessage;
        $this->notificationType = $type;
        $this->modalopen = $modalopen;
    }    
    public function rulesDataMerchant(){
        return[
            'namamerchant'=>'required|string|max:255',
            'almmerchant'=>'required|string|max:500',
            'nopd'=>'required|string|max:50',
            'deviceid'=>'required|string|max:50',
            ];
    }
    public function messages()
        {
            return [
                'required' => 'Kolom isian tidak boleh kosong.',
                'string' => 'Kolom isian harus berupa text.',
                'nama.max' => 'Nama tidak boleh lebih dari 255 karakter.',
                'alamat.max' => 'Alamat tidak boleh lebih dari 500 karakter.'
                // Tambahkan pesan kustom lainnya jika diperlukan
            ];
        }
    public function tambahData(){
        $this->hidden='';
        $this->tablehidden='hidden';
        $this->reset(['namamerchant', 'nopd','deviceid','almmerchant']); 
        $this->wiresubmit="inputData";

    }
    public function editData($id){
        $this->hidden='';
        $this->tablehidden='hidden';
        $this->wiresubmit="updateData";
        $data=Merchants::where('id',$id)->first();
        $this->id=$data->id;
        $this->namamerchant=$data->nm_merchant;
        $this->nopd=$data->nopd;
        $this->almmerchant=$data->alm_merchant;
        $this->deviceid=$data->device_id;
        
    }
    
    public function inputData(){
        
        $data=Merchants::where('nopd',$this->nopd)->first();
        
        if(empty($data)){
        $namamerchant=Str::upper($this->namamerchant);
        $deviceid=Str::upper($this->deviceid);
        $nopd=Str::upper($this->nopd);
        $almmerchant=Str::upper($this->almmerchant);
        $this->validate($this->rulesDataMerchant());
            Merchants::create([ 
                'nm_merchant' => $namamerchant,
                'device_id' => $deviceid,
                'nopd' => $nopd,
                'alm_merchant' => $almmerchant,
            ]);

            Session::flash('notification', [
                'message' => 'Data berhasil disimpan!',
                'type' => 'success',
                'open' => true,
            ]);
            return redirect()->route('merchants');
        }else{
            Session::flash('notification', [
                'message' => 'Data Gagas disimpan!Karena Sudah Terdaftar',
                'type' => 'error',
                'open' => true,
            ]);
            return redirect()->route('merchants');
        }
    }
    public function updateData(){
        
        $data=Merchants::where('nopd',$this->nopd)->first();
        
        if(!empty($data)){
        $namamerchant=Str::upper($this->namamerchant);
        $deviceid=Str::upper($this->deviceid);
        $nopd=Str::upper($this->nopd);
        $almmerchant=Str::upper($this->almmerchant);
        $this->validate($this->rulesDataMerchant());
            $data->update([ 
                'nm_merchant' => $namamerchant,
                'device_id' => $deviceid,
                'nopd' => $nopd,
                'alm_merchant' => $almmerchant,
            ]);

            Session::flash('notification', [
                'message' => 'Data berhasil disimpan!',
                'type' => 'success',
                'open' => true,
            ]);
            return redirect()->route('merchants');
        }else{
            Session::flash('notification', [
                'message' => 'Data Gagas disimpan!Data Merchat Tidak Ditemukan',
                'type' => 'error',
                'open' => true,
            ]);
            return redirect()->route('merchants');            
        }
    }
    public function modalImport(){
        $this->setModal('formupload','','');
    }
    public function modalDelete($id){
        $this->setModal('Anda akan menghapus Data ini?','error',$id);
    }
    public function deleteData($id){
        $data=Merchants::where('id',$id)->first();
        if(!empty($data)){
            $data->delete();
            Session::flash('notification', [
                'message' => 'Data Berhasil Disimpan!',
                'type' => 'error',
                'open' => true,
            ]);
            return redirect()->route('merchants');
        }
        else{
            Session::flash('notification', [
                'message' => 'Data Tidak Ada!',
                'type' => 'error',
                'open' => true,
            ]);
            return redirect()->route('merchants');
        }
    }
    public function exportData()
    {
        return Excel::download(new MerchantDatasExport(), 'merchant.xlsx');
    }
    public function importData()
    {
        
        $this->validate([
            'fileexcel' => 'required|file|mimes:xlsx',
        ]);

        Excel::import(new importDataMerchant, $this->fileexcel->getRealPath());

        Session::flash('notification', [
            'message' => 'Berhasil Import Data',
            'type' => 'success',
            'open' => true,
        ]);
        return redirect()->route('merchants');
    }
}

