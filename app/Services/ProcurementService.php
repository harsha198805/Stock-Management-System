<?php

namespace App\Services;

use App\Repositories\Interfaces\ProcurementRepositoryInterface;
use App\Services\PurchaseOrderService;

class ProcurementService
{
    protected $repo;
    protected $poService;

    public function __construct(ProcurementRepositoryInterface $repo, PurchaseOrderService $poService)
    {
        $this->repo = $repo;
        $this->poService = $poService;
    }

    public function getAllPaginated(int $perPage = 10)
    {
        return $this->repo->allWithItemsPaginated($perPage);
    }

    public function create(array $data, array $items)
    {
        return $this->repo->createProcurement($data, $items);
    }

    public function update($id, array $data, array $items)
    {
        return $this->repo->updateProcurement($id, $data, $items);
    }

    public function find($id)
    {
        return $this->repo->findWithItems($id);
    }

    public function delete($id)
    {
        $this->repo->delete($id);
    }

    public function searchAndPaginate(?string $search = null, $perPage = null, $status = null, $startDate = null, $endDate = null, $sort_by = null, $sort_dir = null)
    {
        return $this->repo->searchAndPaginate($search, $perPage, $status, $startDate, $endDate, $sort_by, $sort_dir);
    }

    public function getAllSuppliers()
    {
        return $this->repo->getAllSuppliers();
    }

    public function getAllStockItem()
    {
        return $this->repo->getAllStockItem();
    }

    public function allProcurementWithItems()
    {
        return $this->repo->allProcurementWithItems();
    }

    public function approveProcurement(int $id, int $userId)
    {
        $procurement = $this->repo->findWithItems($id);

        if ($procurement->status !== 'approved') {
            $this->repo->updateStatus($procurement, 'approved');
        }

        return $this->poService->generate($procurement, $userId);
    }
}
