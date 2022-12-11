<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Item extends Model
{
    use HasFactory ,SoftDeletes;

    /**
     * declare not filable fields
    */
    protected $guarded = [];

    /**
     * @return BelongsTo
    */
    public function vendor():BelongsTo
    {
       return $this->belongsTo(Vendor::class);
    }

    /**
     * @return BelongsToMany
    */
    public function attributes():BelongsToMany
    {
       return $this->belongsToMany(Attribute::class ,'attribute_values');
    }
}
