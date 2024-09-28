<?php

namespace App\Livewire;

use Illuminate\Support\Facades\DB;
use App\Models\Undians;
use App\Models\Pemenang;
use Livewire\Component;

class Pengundian extends Component
{
    public $isDrawing = false;
    public $finishDraw = false;
    public $hadiah = 1; // Ubah jika kamu ingin lebih dari 1 hadiah
    public $winners = [];
    
    // Menyimpan nomor dan nama pemenang
    public $winner1no = '', $winner1name = '';
    public $winner2no = '', $winner2name = '';
    public $winner3no = '', $winner3name = '';
    public $winner4no = '', $winner4name = '';
    public $winner5no = '', $winner5name = '';

    public function render()
    {
        return view('livewire.pengundian');
    }

    public function undiPemenang()
    {
        $this->resetWinners();

        // Ambil peserta
        $nominasi = DB::table('undians')
            ->leftJoin('regs', 'undians.reg_id', '=', 'regs.id')
            ->leftJoin('wp_datas', 'regs.nik', '=', 'wp_datas.nik')
            ->select('undians.id','undians.no_undian', 'wp_datas.nm_wp', 'wp_datas.nik')
            ->get();

        if ($nominasi->isEmpty()) {
            session()->flash('error', 'Belum ada peserta yang mendaftar.');
            return;
        }

        // Ambil semua nik yang sudah ada di tabel pemenangs
        $dataPemenang = DB::table('pemenangs')->pluck('nik')->toArray();
        
        // Acak pemenang
        $this->selectMultipleWinners($nominasi, $this->hadiah, $dataPemenang);
        $this->finishDraw = true;
    }

    private function selectMultipleWinners($nominasi, $count, $dataPemenang)
    {
        $winners = [];
        $winnerSet = [];


        for ($i = 0; $i < 50; $i++) {
            // Mengacak pemenang
            for ($j = 1; $j <= $this->hadiah; $j++) {
                $winner = $nominasi->shuffle()->random();

                // Update nomor dan nama pemenang di Livewire stream
                $this->stream(to: "winner{$j}no", content: $this->{"winner{$j}no"} = $winner->no_undian, replace: true);
                $this->stream(to: "winner{$j}name", content: $this->{"winner{$j}name"} = $winner->nm_wp, replace: true);
            }
            
            usleep(100000); // Jeda 100ms untuk efek visual
        }

        


        while (count($winners) < $count && count($winners) < $nominasi->count()) {
            $winner = $nominasi->shuffle()->random();
            // dd($winner);

            // Cek apakah nik sudah terdaftar atau sudah ada di pemenang
            if (!isset($winnerSet[$winner->nik]) && !in_array($winner->nik, $dataPemenang)) {
                $winners[] = $winner;
                $winnerSet[$winner->nik] = true; // Track unique winners

                Pemenang::create([
                    'id_undian' => $winner->id,
                    'nik' => $winner->nik,
                    'no_undian' => $winner->no_undian,
                    'nama' => $winner->nm_wp,
                    // Tambahkan kolom lain sesuai kebutuhan
                ]);
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
        $this->winner1no = $this->winner1name = '';
        $this->winner2no = $this->winner2name = '';
        $this->winner3no = $this->winner3name = '';
        $this->winner4no = $this->winner4name = '';
        $this->winner5no = $this->winner5name = '';
    }
}
