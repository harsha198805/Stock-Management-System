<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockItem;
use App\Models\Procurement;
use App\Models\PurchaseOrder;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $stockCount = StockItem::count();
        $procurementCount = Procurement::count();
        $purchaseOrderCount = PurchaseOrder::count();

        return view('layouts.dashboard', compact('stockCount', 'procurementCount', 'purchaseOrderCount'));
    }
}
