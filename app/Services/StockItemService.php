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

    public function searchAndPaginate(?string $search = null, int $perPage = 10, $status = null, $startDate = null, $endDate = null)
    {
        return $this->stockRepo->searchAndPaginate($search, $perPage, $status, $startDate, $endDate);
    }

    public function find($id)
    {
        return $this->stockRepo->find($id);
    }
}
