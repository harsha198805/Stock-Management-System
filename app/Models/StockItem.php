<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use OwenIt\Auditing\Contracts\Auditable;

class StockItem extends Model implements Auditable
{
    const STATUS_INACTIVE = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_OUT_OF_STOCK = 2;
    
    use \OwenIt\Auditing\Auditable;

    protected $fillable = [
        'name',
        'code',
        'quantity',
        'unit_price',
        'status',
    ];

    public $timestamps = true;

    protected $casts = [
        'unit_price' => 'float',
        'quantity' => 'integer',
    ];

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            self::STATUS_ACTIVE => 'Active',
            self::STATUS_INACTIVE => 'Inactive',
            self::STATUS_OUT_OF_STOCK => 'Out of Stock',
            default => 'Unknown',
        };
    }
}
