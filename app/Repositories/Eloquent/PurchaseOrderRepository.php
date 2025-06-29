<?php

namespace App\Repositories\Eloquent;

use App\Models\PurchaseOrder;
use App\Repositories\Interfaces\PurchaseOrderRepositoryInterface;

class PurchaseOrderRepository implements PurchaseOrderRepositoryInterface
{
    public function generate($procurement, $userId)
    {
        if (!$procurement->purchaseOrder) {
            PurchaseOrder::create([
                'procurement_id' => $procurement->id,
                'created_by' => $userId,
                'generated_at' => now(),
            ]);
        }
    }

    public function allWithProcurement()
    {
        return PurchaseOrder::with('procurement.stockItems')->latest()->get();
    }

    public function findWithDetails(int $id): PurchaseOrder
    {
        return PurchaseOrder::with('procurement.items.stockItem')->findOrFail($id);
    }

    public function queryWithRelations()
    {
        return PurchaseOrder::with('procurement.items.stockItem')->latest();
    }

     public function paginateWithFilters(array $filters = [], int $perPage = 10)
    {
        $query = $this->queryWithRelations();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where('id', $search)
                  ->orWhereHas('procurement', function ($q) use ($search) {
                      $q->where('reference_no', 'like', "%{$search}%");
                  });
        }

        if (!empty($filters['start_date'])) {
            $query->whereDate('created_at', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->whereDate('created_at', '<=', $filters['end_date']);
        }

        return $query->paginate($perPage)->withQueryString();
    }
}
