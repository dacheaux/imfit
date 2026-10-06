<?php

namespace App;

use Illuminate\Support\Carbon;

class Order extends Model
{
    protected $table = 'orders';

    protected $fillable = ['order_amount','order_qty', 'user_id','product_id', 'status'];

    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y. H:i');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'id', 'product_id');
    }

    public function user()
    {
        return $this->belongsTo('App\User');
    }
}
