<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class GlobalConf extends Model
{
    use HasFactory;

    protected $fillable = [ 'time_book', 'time_delay', 'time_pause'];


}
