<?php

namespace App\Repositories\Interfaces;

interface PurchaseOrderRepositoryInterface
{

    public function generate($procurement, int $userId);
    public function allWithProcurement();
    public function findWithDetails(int $id);
    public function queryWithRelations();
    public function paginateWithFilters(array $filters = [], int $perPage = 10);
}
