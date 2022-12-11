<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ProductOption extends Model
{
    use \Backpack\CRUD\app\Models\Traits\CrudTrait;
    use HasFactory ,SoftDeletes;

    /**
     * declare not filable fields
    */
    protected $guarded = [];

    /**
     * The attributes that should be cast.
     *
     * @var json <string, string>
    */
    protected $casts = [
        'config' => 'json',
    ];
        /**
     * Appends to JSON
     *
     * @var string[]
     */
    protected $appends = [
        'full_name'
    ];

    const TYPES=['just_one','zero_or_more', 'one_or_more','counter'];

    /**
     * @return BelongsTo
    */
    public function product():BelongsTo
    {
       return $this->belongsTo(Product::class);
    }    
    /**
    * Set the stag's full data.
    *
    * @param  string  $value
    * @return String
    */
    public function getFullNameAttribute($value) {
        return $this->config;
     }
}
