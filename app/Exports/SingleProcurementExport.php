<?php
namespace App\Exports;

use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class SingleProcurementExport implements FromView
{
    protected $procurement;

    public function __construct($procurement)
    {
        $this->procurement = $procurement;
    }

    public function view(): View
    {
        return view('exports.excel.individual_procurement', [
            'procurement' => $this->procurement,
        ]);
    }
}