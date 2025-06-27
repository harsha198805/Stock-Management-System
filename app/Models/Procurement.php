<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Procurement extends Model
{
    use SoftDeletes;

    protected $fillable = [
        'reference_no',
        'procurement_date',
        'supplier_id',
        'status',
    ];

    public function items()
    {
        return $this->hasMany(ProcurementItem::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }
}
