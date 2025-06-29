<?php

namespace App\Services;

use App\Repositories\Interfaces\StockItemRepositoryInterface;

class StockItemService
{
    protected $stockRepo;

    public function __construct(StockItemRepositoryInterface $stockRepo)
    {
        $this->stockRepo = $stockRepo;
    }

    public function getAll()
    {
        return $this->stockRepo->all();
    }

    public function create(array $data)
    {
        return $this->stockRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->stockRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->stockRepo->delete($id);
    }

    public function searchAndPaginate(?string $search = null, $perPage = null, $status = null, $startDate = null, $endDate = null, $sort_by = null, $sort_dir = null)
    {
        return $this->stockRepo->searchAndPaginate($search, $perPage, $status, $startDate, $endDate, $sort_by, $sort_dir);
    }

    public function find($id)
    {
        return $this->stockRepo->find($id);
    }
}
