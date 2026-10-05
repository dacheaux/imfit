<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{

    protected $fillable = ['name', 'uri','gallery'];


    public function photos()
    {
        return $this->hasMany('App\Photo', 'photo_id');
    }
}
