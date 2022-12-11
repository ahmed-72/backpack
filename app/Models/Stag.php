<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stag extends Model
{
    use HasFactory;

    protected $fillable = [
        'id','tag_id',
        'details',
    ];


    public function tag()
    {
        return $this->belongsTo(Tag::class);
    }
    /**
     * Set the stag's full data.
     *
     * @param  string  $value
     * @return String
     */
    public function getFullNameAttribute($value): String
    {
        return $this->tag_id.' -> '.$this->details;
    }

}
