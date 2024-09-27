<?php

namespace App\Livewire;
use Illuminate\Support\Facades\DB;
use App\Models\Undians;
use App\Models\Pemenang;

use Livewire\Component;

class Drawundian extends Component
{
    public $isDrawing = false; // Status pengacakan
    public $finishDraw = false; // Status pengacakan
    public $winner1no='';
    public $winner2no='';
    public $winner3no='';
    public $winner4no='';
    public $winner5no='';
    public $winner1name='';
    public $winner2name='';
    public $winner3name='';
    public $winner4name='';
    public $winner5name='';
    
    public function render()
    {
        
        return view('livewire.drawundian');
    }

    public function undiPemenang()
    {
        $this->isDrawing=false;
        $this->resetWinners();
        
        // Fetch participants
        $nominasi = DB::table('undians')
            ->leftJoin('regs', 'undians.reg_id', '=', 'regs.id')
            ->leftJoin('wp_datas', 'regs.nik', '=', 'wp_datas.nik')
            ->select(
                'undians.id as undian_id', 
                'undians.no_undian as no_undian', 
                'regs.id as no_reg', 
                'regs.merchant_id as merchant_id', 
                'wp_datas.nik as nik',
                'wp_datas.nm_wp as nm_wp',
                'wp_datas.no_hp as no_hp'
            )
            // ->where('merchant_id','=','91')
            ->get();
            // dd($nominasi);
    
        if ($nominasi->isEmpty()) {
            session()->flash('error', 'Belum ada peserta yang mendaftar.');
            return;
        }
    
        $nominasi = $nominasi->shuffle();
    
        // Ambil semua nik yang sudah ada di tabel pemenangs
        $dataPemenang = DB::table('pemenangs')->pluck('nik')->toArray();
        sleep(6)    ;
        $this->selectMultipleWinners($nominasi, 1, $dataPemenang);
        $this->finishDraw=true;
    }
    
    private function selectMultipleWinners($nominasi, $count, $dataPemenang)
    {
        $winners = [];
        $winnerSet = [];
        
        while (count($winners) < $count && count($winners) < $nominasi->count()) {
            $winner = $nominasi->random();
            if (!isset($winnerSet[$winner->nik]) && !in_array($winner->nik, $dataPemenang)) {
                $winners[] = $winner;
                $winnerSet[$winner->nik] = true; // Use associative array for unique tracking
                
            }
        }
    
        // Assign winners to properties
        foreach ($winners as $index => $winner) {
            if ($index < 5) {
                $this->{'winner' . ($index + 1) . 'no'} = $winner->no_undian ?? '';
                $this->{'winner' . ($index + 1) . 'name'} = $winner->nm_wp ?? '';
            }
        }
    }
    
    
    private function resetWinners()
    {
        $this->winner1no = '';
        $this->winner2no = '';
        $this->winner3no = '';
        $this->winner4no = '';
        $this->winner5no = '';
        $this->winner1name = '';
        $this->winner2name = '';
        $this->winner3name = '';
        $this->winner4name = '';
        $this->winner5name = '';
    }
    
    
}