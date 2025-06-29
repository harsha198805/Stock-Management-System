<?php
namespace App\Exports;


use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class StockItemsExport implements FromView
{
    protected $items;

    public function __construct($items)
    {
        $this->items = $items;
    }

    public function view(): View
    {
        return view('exports.excel.stock_items', [
            'items' => $this->items,
        ]);
    }
}