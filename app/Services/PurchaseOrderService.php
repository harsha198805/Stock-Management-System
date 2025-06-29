<?php

namespace App\Services;

use App\Repositories\Interfaces\PurchaseOrderRepositoryInterface;

class PurchaseOrderService
{
    protected $poRepo;

    public function __construct(PurchaseOrderRepositoryInterface $poRepo)
    {
        $this->poRepo = $poRepo;
    }
    public function generate($procurement, $userId)
    {
        if (!$procurement->purchaseOrder) {
            return \App\Models\PurchaseOrder::create([
                'procurement_id' => $procurement->id,
                'created_by' => $userId,
                'generated_at' => now(),
            ]);
        }

        return $procurement->purchaseOrder;
    }

    public function all()
    {
        return $this->poRepo->allWithProcurement();
    }
    public function findWithDetails(int $id)
    {
        return $this->poRepo->findWithDetails($id);
    }

    public function searchOrders(array $filters = [], int $perPage = 10)
    {
        return $this->poRepo->paginateWithFilters($filters, $perPage);
    }
}
