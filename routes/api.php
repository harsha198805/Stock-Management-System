<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\StockItemController;

Route::get('/stock/total-count', function () {
    return response()->json(['total' => \App\Models\StockItem::sum('quantity')]);
})->name('api.stock.totalCount');
Route::get('/stock/total-count', [StockItemController::class, 'totalCount'])->name('api.stock.totalCount');