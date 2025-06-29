<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\StockItem;
use App\Models\Procurement;
use App\Models\PurchaseOrder;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $stockCount = StockItem::count();
        $procurementCount = Procurement::count();
        $purchaseOrderCount = PurchaseOrder::count();
        $userCount = User::count();
        $auditCount = \OwenIt\Auditing\Models\Audit::count();

        return view('layouts.dashboard', compact('stockCount', 'procurementCount', 'purchaseOrderCount', 'userCount', 'auditCount'));
    }
}
