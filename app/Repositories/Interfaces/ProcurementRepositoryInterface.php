<?php

namespace App\Repositories\Interfaces;

interface ProcurementRepositoryInterface
{
    public function allWithItemsPaginated(int $perPage = 10);
    public function createProcurement(array $data, array $items);
    public function updateProcurement($id, array $data, array $items);
    public function findWithItems($id);
    public function delete($id);
    public function searchAndPaginate(?string $search = null, int $perPage = 10, $status = null, $startDate = null, $endDate = null);
    public function getAllSuppliers();
    public function getAllStockItem();
}
