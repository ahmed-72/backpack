<?php

namespace App\Models;

use Backpack\CRUD\app\Models\Traits\CrudTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Order extends Model
{
    use CrudTrait;
    use HasFactory, SoftDeletes;

    /**
     * declare not filable fields
     */
    protected $guarded = [];

    /**
     * @return BelongsTo
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * @return BelongsTo
    */
    public function discount():BelongsTo
    {
       return $this->belongsTo(Discount::class);
    }

    /**
     * @return HasMany
    */
    public function products(): HasMany
    {
        return $this->hasMany(OrderProduct::class);
    }

    /**
     * @return HasMany
    */
    public function available_products()
    {
        return Product::class;
    }

}
