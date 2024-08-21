<?php

namespace App\Livewire;

use Livewire\Component;

use Illuminate\Support\Facades\DB;
use App\Models\Merchants;
use Livewire\WithPagination;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\RegDatasExport;

class Merchant extends Component
{
    public function render()
    {
        $datamerchants=Merchants::paginate(2);
        return view('livewire.merchants',['datamerchants' => $datamerchants]);
    }
}
