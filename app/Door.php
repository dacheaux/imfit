<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Door extends Model
{
    protected $table = 'doors';

    protected $fillable = [ 'door_state'];

}
