<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\PurchaseOrderService;
use PDF;

class PurchaseOrderController extends Controller
{
    public function __construct(private PurchaseOrderService $poService) {}

    public function index1()
    {
        $orders = $this->poService->all();
        return view('purchase_orders.index', compact('orders'));
    }
    public function index(Request $request)
    {
        $filters = [
            'search' => $request->input('search'),
            'start_date' => $request->input('start_date'),
            'end_date' => $request->input('end_date'),
        ];

        $orders = $this->poService->searchOrders($filters, $perPage = 10);

        return view('purchase_orders.index', compact('orders'));
    }

    public function downloadPdf(int $id)
    {
        $order = $this->poService->findWithDetails($id);
        $pdf = PDF::loadView('purchase_orders.pdf', compact('order'));
        return $pdf->download('PO_' . $order->id . '_' . now()->format('YmdHis') . '.pdf');
    }
}
