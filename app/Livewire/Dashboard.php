<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Support\Facades\DB;
use App\Models\Regs;
class Dashboard extends Component
{
    public function render()
    {$dataregs = DB::table('regs')
        ->select(
            DB::raw("COUNT(CASE WHEN status_id > 0 THEN 1 END) as semua"),
            DB::raw("COUNT(CASE WHEN status_id = '1' or status_id='2' THEN 1 END) as permohonan"),
            DB::raw("COUNT(CASE WHEN status_id = '3' THEN 1 END) as diterima"),
            DB::raw("COUNT(CASE WHEN status_id = '4' THEN 1 END) as ditolak")
            
        )
        ->first();
        // dd($dataregs);
        return view('livewire.dashboard', ['dataregs' => $dataregs]);
    }
    public function regDatas($statusid){
        $this->redirectRoute('regdatastatus', $statusid);
    }
}
