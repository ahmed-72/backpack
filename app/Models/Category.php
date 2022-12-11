<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use Illuminate\Support\Facades\Storage;

class Category extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory, SoftDeletes;

    /**
     * declare not filable fields
     */
    protected $guarded = [];


    /**
     * @return BelongsTo
     */
    public function vendors(): BelongsToMany
    {
        return $this->belongsToMany(Vendor::class , 'vendor_categories');
    }

    /**
     * @return BelongsTo
     */
    public function products(): BelongsToMany
    {
        return $this->belongsToMany(Product::class , 'product_categories');
    }
}
