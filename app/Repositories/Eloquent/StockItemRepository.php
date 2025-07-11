<?php

namespace App\Repositories\Eloquent;

use App\Models\StockItem;
use App\Events\StockUpdated;
use App\Repositories\Interfaces\StockItemRepositoryInterface;

class StockItemRepository implements StockItemRepositoryInterface
{
    public function all()
    {
        return StockItem::all();
    }

    public function find($id)
    {
        return StockItem::findOrFail($id);
    }

    public function create(array $data)
    {
        return StockItem::create($data);
    }

    public function update($id, array $data)
    {
        $stockItem = StockItem::findOrFail($id);
        $stockItem->update($data);
        event(new StockUpdated($stockItem));
        return $stockItem;
    }

    public function delete($id)
    {
        return StockItem::destroy($id);
    }

    public function searchAndPaginate(?string $search = null, $perPage = null, $status = null, $startDate = null, $endDate = null, $sort_by = 'created_at', $sort_dir = 'desc')
    {
        $query = StockItem::query();

        if (!empty($search)) {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('code', 'like', "%{$search}%");
            });
        }

        $query->when($status !== null, function ($query) use ($status) {
            $query->where('status', $status);
        })
            ->when($startDate, function ($query, $startDate) {
                $query->whereDate('created_at', '>=', $startDate);
            })
            ->when($endDate, function ($query, $endDate) {
                $query->whereDate('created_at', '<=', $endDate);
            });

        $query->orderBy($sort_by, $sort_dir);
        return !empty($perPage) ? $query->paginate($perPage) : $query->get();
    }
}
