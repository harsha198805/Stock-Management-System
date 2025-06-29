<?php

namespace App\Repositories\Eloquent;

use App\Models\Procurement;
use App\Models\ProcurementItem;
use App\Repositories\Interfaces\ProcurementRepositoryInterface;
use App\Models\Supplier;
use App\Models\StockItem;

class ProcurementRepository implements ProcurementRepositoryInterface
{
    public function allWithItemsPaginated(int $perPage = 10)
    {
        return Procurement::with('items.stockItem', 'supplier')->paginate($perPage);
    }
    public function allProcurementWithItems()
    {
        return Procurement::with('items.stockItem', 'supplier')->get();
    }

    public function createProcurement(array $data, array $items)
    {
        $procurement = Procurement::create($data);
        foreach ($items as $item) {
            $procurement->items()->create($item);
        }
        return $procurement;
    }

    public function updateProcurement($id, array $data, array $items)
    {
        $procurement = Procurement::findOrFail($id);
        $procurement->update($data);

        $existingIds = $procurement->items()->pluck('id')->toArray();
        $sentIds = collect($items)->pluck('id')->filter()->toArray();
        $toDelete = array_diff($existingIds, $sentIds);

        ProcurementItem::destroy($toDelete);

        foreach ($items as $item) {
            if (isset($item['id'])) {
                ProcurementItem::where('id', $item['id'])->update([
                    'stock_item_id' => $item['stock_item_id'],
                    'quantity' => $item['quantity'],
                    'unit_price' => $item['unit_price'],
                ]);
            } else {
                $procurement->items()->create($item);
            }
        }

        return $procurement;
    }

    public function findWithItems($id)
    {
        return Procurement::with('items.stockItem', 'supplier')->findOrFail($id);
    }

    public function delete($id)
    {
        Procurement::destroy($id);
    }

    public function searchAndPaginate(?string $search = null, int $perPage = 10, $status = null, $startDate = null, $endDate = null)
    {
        $query = Procurement::with('items.stockItem', 'supplier');

        if (!empty($search)) {
            $query->where('reference_no', 'like', "%{$search}%");
        }

        if (!empty($status)) {
            $query->where('status', $status);
        }

        if (!empty($startDate)) {
            $query->whereDate('procurement_date', '>=', $startDate);
        }

        if (!empty($endDate)) {
            $query->whereDate('procurement_date', '<=', $endDate);
        }

        return $query->orderBy('procurement_date', 'desc')->paginate($perPage);
    }

    public function getAllSuppliers()
    {
        return Supplier::all();
    }

    public function getAllStockItem()
    {
        return StockItem::all();
    }

    public function findByIdWithItems(int $id)
    {
        return Procurement::with(['items.stockItem', 'purchaseOrder'])->findOrFail($id);
    }

    public function updateStatus($procurement, string $status): void
    {
        $procurement->status = $status;
        $procurement->save();
    }
}
