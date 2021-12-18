<?php

namespace Modules\Ecommerce\Entities;

use Illuminate\Database\Eloquent\Model;

class StockLog extends Model
{
    public function productStock()
    {
        return $this->belongsTo(ProductStock::class, 'stock_id');
    }
}
