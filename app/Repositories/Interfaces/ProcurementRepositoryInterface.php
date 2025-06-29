<?php

namespace App\Repositories\Interfaces;

interface ProcurementRepositoryInterface
{
    public function allWithItemsPaginated(int $perPage = 10);
    public function createProcurement(array $data, array $items);
    public function updateProcurement($id, array $data, array $items);
    public function findWithItems($id);
    public function delete($id);
    public function searchAndPaginate(?string $search = null, $perPage = null, $status = null, $startDate = null, $endDate = null, $sort_by = null, $sort_dir = null);
    public function getAllSuppliers();
    public function getAllStockItem();
    public function allProcurementWithItems();
    public function findByIdWithItems(int $id);
    public function updateStatus($procurement, string $status): void;
}
