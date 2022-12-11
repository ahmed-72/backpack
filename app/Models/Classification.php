<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\SoftDeletes;


class Classification extends Model
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
    public function vendors():BelongsToMany
    {
       return $this->belongsToMany(Vendor::class , 'vendor_classifications');
    }

}
