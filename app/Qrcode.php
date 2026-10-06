<?php

namespace App;


class Qrcode extends Model
{

    protected $table = 'qrcodes';

    protected $fillable = [ 'user_id', 'token', 'qrcode_image', 'type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
