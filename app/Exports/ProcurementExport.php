<?php

namespace App\Exports;

use App\Models\Procurement;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;

class ProcurementExport implements FromCollection, WithHeadings
{
    public function collection()
    {
        return Procurement::withCount('items')
            ->select('reference_no', 'procurement_date', 'status')
            ->get()
            ->map(function ($proc) {
                return [
                    $proc->reference_no,
                    $proc->procurement_date,
                    ucfirst($proc->status),
                    $proc->items_count,
                ];
            });
    }

    public function headings(): array
    {
        return ['Reference No', 'Date', 'Status', 'Total Items'];
    }
}
