<?php
namespace App\Services;

use App\Repositories\Interfaces\ProcurementRepositoryInterface;

class ProcurementService
{
    protected $repo;

    public function __construct(ProcurementRepositoryInterface $repo)
    {
        $this->repo = $repo;
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

    public function searchAndPaginate(?string $search = null, int $perPage = 10, $status = null, $startDate = null, $endDate = null)
    {
        return $this->repo->searchAndPaginate($search, $perPage, $status, $startDate, $endDate);
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
}
