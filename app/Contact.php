<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;


class Contact extends Model
{
    protected $fillable = ['name', 'email', 'theme', 'question', 'ip_adress', 'seen'];

     public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y. H:i');
    }
}
