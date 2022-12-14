<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OrderProductOption extends Model
{
    use CrudTrait, HasFactory;

    /**
     * declare not filable fields
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
    */
    public function order_product():BelongsTo
    {
       return $this->belongsTo(OrderProduct::class);
    }   
    
    /**
     * @return BelongsTo
    */
    public function product_option():BelongsTo
    {
       return $this->belongsTo(ProductOption::class);
    }   
}
