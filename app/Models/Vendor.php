<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;

class Vendor extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory ,SoftDeletes;

    /**
     * declare not filable fields
    */
    protected $guarded = [];

    /**
     * @return BelongsToMany
    */
    public function categories():BelongsToMany
    {
       return $this->belongsToMany(Category::class , 'vendor_categories')->where('type','vendor');
    }

    /**
     * @return HasMany
    */
    public function products():HasMany
    {
       return $this->hasMany(Product::class);
    }

}
