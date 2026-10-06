<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Account extends Model
{
    use HasFactory;

    protected $fillable = [ 'user_id', 'balance'];


    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
