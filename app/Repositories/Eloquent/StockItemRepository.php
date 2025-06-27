<?php

namespace App\Repositories\Eloquent;

use App\Models\StockItem;
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
        $item = StockItem::findOrFail($id);
        $item->update($data);
        return $item;
    }

    public function delete($id)
    {
        return StockItem::destroy($id);
    }

    public function searchAndPaginate(?string $search = null, int $perPage = 10, $status = null, $startDate = null, $endDate = null)
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

        return $query->orderBy('created_at', 'desc')->paginate($perPage);
    }
}
