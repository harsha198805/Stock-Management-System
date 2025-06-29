<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\ProcurementService;
use PDF;
use App\Exports\ProcurementExport;
use App\Exports\SingleProcurementExport;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\Auth;


class ProcurementController extends Controller
{
    public function __construct(private ProcurementService $procurementService) {}

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sort_by = $request->get('sort_by', 'created_at');
        $sort_dir = $request->get('sort_dir', 'desc');

        $procurements = $this->procurementService->searchAndPaginate($search, $perPage = 10, $status, $startDate, $endDate, $sort_by, $sort_dir);

        return view('procurements.index', compact('procurements', 'search', 'status', 'startDate', 'endDate'));
    }
    public function create()
    {
        $datePart = now()->format('Ymd');
        $count = \App\Models\Procurement::whereDate('created_at', now()->toDateString())->count() + 1;
        $referenceNo = sprintf("PO-%s-%03d", $datePart, $count);
        $stockItems = $this->procurementService->getAllStockItem();
        $suppliers = $this->procurementService->getAllSuppliers();
        return view('procurements.create', compact('referenceNo', 'stockItems', 'suppliers'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'reference_no' => 'required|unique:procurements,reference_no',
            'procurement_date' => 'required|date',
            'status' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.stock_item_id' => 'required|exists:stock_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $data = $request->only(['reference_no', 'procurement_date', 'status', 'supplier_id']);
        $items = $request->input('items');
        $this->procurementService->create($data, $items);

        return redirect()->route('procurements.index')->with('success', 'Procurement created successfully.');
    }

    public function edit($id)
    {
        $procurement = $this->procurementService->find($id);
        $stockItems = $this->procurementService->getAllStockItem();
        $suppliers = $this->procurementService->getAllSuppliers();
        return view('procurements.edit', compact('procurement', 'stockItems', 'suppliers'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'reference_no' => 'required|unique:procurements,reference_no,' . $id,
            'procurement_date' => 'required|date',
            'status' => 'required|string',
            'supplier_id' => 'required|exists:suppliers,id',
            'items' => 'required|array|min:1',
            'items.*.id' => 'nullable|exists:procurement_items,id',
            'items.*.stock_item_id' => 'required|exists:stock_items,id',
            'items.*.quantity' => 'required|integer|min:1',
            'items.*.unit_price' => 'required|numeric|min:0',
        ]);

        $data = $request->only(['reference_no', 'procurement_date', 'status', 'supplier_id']);
        $items = $request->input('items');
        $this->procurementService->update($id, $data, $items);

        return redirect()->route('procurements.index')->with('success', 'Procurement updated successfully.');
    }

    public function destroy($id)
    {
        $this->procurementService->delete($id);
        return redirect()->route('procurements.index')->with('success', 'Procurement deleted successfully.');
    }

    public function downloadSlip($id)
    {
        $procurement = $this->procurementService->find($id);
        $pdf = PDF::loadView('procurements.po_pdf', compact('procurement'));
        return $pdf->download("procurements-{$procurement->reference_no}.pdf");
    }

    public function exportExcel(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $sort_by = $request->get('sort_by', 'created_at');
        $sort_dir = $request->get('sort_dir', 'desc');
        $procurement = $this->procurementService->searchAndPaginate($search, $perPage = null, $status, $startDate, $endDate, $sort_by, $sort_dir);
        $fileName = 'Procurement_' . now()->format('Ymdhis') . '.xlsx';
        return Excel::download(new ProcurementExport($procurement), $fileName);
    }

    public function exportSingle($id)
    {
        $procurement = $this->procurementService->find($id);
        $fileName = 'Procurement_' . $procurement->reference_no . '_' . now()->format('Ymdhis') . '.xlsx';
        return Excel::download(new SingleProcurementExport($procurement), $fileName);
    }

    public function approve(int $id)
    {
        $this->procurementService->approveProcurement($id, auth()->id());
        return redirect()->route('purchase-orders.index')->with('success', 'Procurement approved and PO generated.');
    }
}
