<?php

use Illuminate\Support\Facades\Route;

use App\Http\Controllers\StockItemController;
use App\Http\Controllers\ProcurementController;
use App\Http\Controllers\PurchaseOrderController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\AuditLogController;
use Illuminate\Support\Facades\Auth;

Auth::routes(['register' => false]);
Route::get('/', function () {
    return redirect()->route('login');
});
Route::get('/stock/total-count', [StockItemController::class, 'totalCount'])->name('api.stock.totalCount');
Route::middleware(['auth'])->group(function () {
    Route::middleware(['auth', 'role:Admin'])->group(function () {
    Route::resource('users', UserController::class)->except(['show']);
    Route::get('/audits', [AuditLogController::class, 'index'])->name('audits.index');
});

 Route::get('/dashboard', [DashboardController::class, 'dashboard'])->name('dashboard');

    Route::middleware(['role:Admin|Manager|Staff'])->group(function () {
        Route::get('stock-items', [StockItemController::class, 'index'])->name('stock-items.index');
        Route::get('stock-items/create', [StockItemController::class, 'create'])->name('stock-items.create');
        Route::post('stock-items', [StockItemController::class, 'store'])->name('stock-items.store');
        Route::get('stock-items/{stock_item}', [StockItemController::class, 'show'])->name('stock-items.show');
        Route::get('stock-items/{stock_item}/edit', [StockItemController::class, 'edit'])->name('stock-items.edit');
        Route::put('stock-items/{stock_item}', [StockItemController::class, 'update'])->name('stock-items.update');
        Route::delete('stock-items/{stock_item}', [StockItemController::class, 'destroy'])->name('stock-items.destroy');
        Route::get('/stock-items/export/excel', [StockItemController::class, 'export'])->name('stock-items.export.excel');
    });


    Route::middleware(['role:Admin|Manager|Staff'])->group(function () {
        Route::get('procurements', [ProcurementController::class, 'index'])->name('procurements.index');
        Route::get('procurements/create', [ProcurementController::class, 'create'])->name('procurements.create');
        Route::post('procurements', [ProcurementController::class, 'store'])->name('procurements.store');
        Route::get('procurements/{procurement}', [ProcurementController::class, 'show'])->name('procurements.show');
        Route::get('procurements/{procurement}/edit', [ProcurementController::class, 'edit'])->name('procurements.edit');
        Route::put('procurements/{procurement}', [ProcurementController::class, 'update'])->name('procurements.update');
        Route::delete('procurements/{procurement}', [ProcurementController::class, 'destroy'])->name('procurements.destroy');
        Route::get('/procurements/export/excel', [ProcurementController::class, 'exportExcel'])->name('procurements.export.excel');
        Route::get('procurements/{id}/export', [ProcurementController::class, 'exportSingle'])->name('procurements.export');
        Route::put('/procurements/{id}/approve', [ProcurementController::class, 'approve'])->name('procurements.approve');
        Route::get('/purchase-orders', [PurchaseOrderController::class, 'index'])->name('purchase-orders.index');
        Route::get('/purchase-orders/{id}/pdf', [PurchaseOrderController::class, 'downloadPdf'])->name('purchase-orders.pdf');
    });

    Route::get('procurements/{id}/pdf', [ProcurementController::class, 'downloadSlip'])
        ->name('procurements.pdf')
        ->middleware('role:Admin|Manager|Staff');

});
