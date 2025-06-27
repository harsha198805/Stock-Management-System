<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Http\Controllers\Guest\TicketController;
use App\Http\Controllers\Agent\AgentTicketController;
use App\Http\Controllers\StockItemController;
use App\Http\Controllers\ProcurementController;

Auth::routes(['register' => false]);
Route::get('/', function () {
    return redirect()->route('login');
});

Route::middleware(['auth'])->group(function () {

    Route::middleware(['role:Admin|Manager|Staff'])->group(function () {
        Route::get('stock-items', [StockItemController::class, 'index'])->name('stock-items.index');
        Route::get('stock-items/create', [StockItemController::class, 'create'])->name('stock-items.create');
        Route::post('stock-items', [StockItemController::class, 'store'])->name('stock-items.store');
        Route::get('stock-items/{stock_item}', [StockItemController::class, 'show'])->name('stock-items.show');
        Route::get('stock-items/{stock_item}/edit', [StockItemController::class, 'edit'])->name('stock-items.edit');
        Route::put('stock-items/{stock_item}', [StockItemController::class, 'update'])->name('stock-items.update');
        Route::delete('stock-items/{stock_item}', [StockItemController::class, 'destroy'])->name('stock-items.destroy');
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

    });

    Route::get('procurements/{id}/pdf', [ProcurementController::class, 'downloadSlip'])
        ->name('procurements.pdf')
        ->middleware('role:Admin|Manager|Staff');

    Route::get('/admin/dashboard', function () {
        return view('dashboard');
    })->middleware('role:Admin')->name('admin.dashboard');

    Route::get('/manager/dashboard', function () {
        return view('dashboard');
    })->middleware('role:Manager')->name('manager.dashboard');

    Route::get('/staff/dashboard', function () {
        return view('dashboard');
    })->middleware('role:Staff')->name('staff.dashboard');


    Route::get('/dashboard', function () {
        $user = auth()->user();

        switch ($user->role) {
            case 'Admin':
                return redirect()->route('admin.dashboard');
            case 'Manager':
                return redirect()->route('manager.dashboard');
            case 'Staff':
                return redirect()->route('staff.dashboard');
            default:
                abort(403, 'No dashboard available for your role.');
        }
    })->middleware('auth')->name('dashboard');
});
