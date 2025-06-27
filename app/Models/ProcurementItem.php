<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProcurementItem extends Model
{
    protected $fillable = [
        'procurement_id',
        'stock_item_id',
        'quantity',
        'unit_price',
    ];

    public function procurement()
    {
        return $this->belongsTo(Procurement::class);
    }

    public function stockItem()
    {
        return $this->belongsTo(StockItem::class);
    }
}
