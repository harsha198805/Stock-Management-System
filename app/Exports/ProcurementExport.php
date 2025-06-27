<?php

namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ProcurementExport implements FromView
{
    protected $procurements;

    public function __construct($procurements)
    {
        $this->procurements = $procurements;
    }

    public function view(): View
    {
        return view('exports.excel.procurements', [
            'procurements' => $this->procurements
        ]);
    }
}
