<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Services\StockItemService;
use App\Exports\StockItemsExport;
use Maatwebsite\Excel\Facades\Excel;

class StockItemController extends Controller
{
    public function __construct(private StockItemService $service)
    {

    }

    public function index(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $items = $this->service->searchAndPaginate($search, $perPage = 10, $status, $startDate, $endDate);
        return view('stock.index', compact('items', 'search', 'startDate', 'endDate', 'status'));
    }

    public function create()
    {
        return view('stock.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required',
            'code' => 'required|unique:stock_items',
            'quantity' => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
            'status' => 'required|in:0,1,2',
        ]);

        $this->service->create($validated);
        return redirect()->route('stock-items.index')->with('success', 'Item added!');
    }

    public function edit($id)
    {
        $item = $this->service->find($id);
        return view('stock.edit', compact('item'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'code'       => 'required|string|max:50|unique:stock_items,code,' . $id,
            'quantity'   => 'required|integer|min:0',
            'unit_price' => 'required|numeric|min:0',
        ]);

        $this->service->update($id, $request->all());
        return redirect()->route('stock-items.index')->with('success', 'Stock item updated.');
    }

    public function destroy($id)
    {
        if (auth()->user()->role !== 'Admin') {
            return redirect()->route('stock-items.index')->with('error', 'Unauthorized action.');
        }

        $this->service->delete($id);
        return redirect()->route('stock-items.index')->with('success', 'Stock item deleted.');
    }

    public function export(Request $request)
    {
        $search = $request->input('search');
        $status = $request->input('status');
        $startDate = $request->input('start_date');
        $endDate = $request->input('end_date');
        $items = $this->service->searchAndPaginate($search, $perPage = 10, $status, $startDate, $endDate);
        return Excel::download(new StockItemsExport($items), 'stock_items_' . now()->format('Ymd_His') . '.xlsx');
    }
}
