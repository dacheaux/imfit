<?php

namespace App;

use Illuminate\Database\Eloquent\Factories\HasFactory;

class Qrcode extends Model
{
    use HasFactory;


    protected $table = 'qrcodes';

    protected $fillable = [ 'user_id', 'token', 'qrcode_image', 'type'];

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
