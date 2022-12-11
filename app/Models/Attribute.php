<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Attribute extends Model
{
    use HasFactory ,SoftDeletes;

    /**
     * declare not filable fields
    */
    protected $guarded = [];

    /**
     * @return BelongsToMany
    */
    public function items():BelongsToMany
    {
       return $this->belongsToMany(Item::class ,'attribute_values','attribute_id');
    }
}
