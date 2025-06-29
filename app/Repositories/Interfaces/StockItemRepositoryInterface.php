<?php

namespace App\Repositories\Interfaces;

interface StockItemRepositoryInterface {
    public function all();
    public function find($id);
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    public function searchAndPaginate(?string $search = null, $perPage = null, $status = null, $startDate = null, $endDate = null, $sort_by = null, $sort_dir = null);
}