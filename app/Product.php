<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

class Product extends Model
{
    protected $table = 'products';

    protected $fillable = [
        'product_name',
        'product_price',
        'product_image',
        'product_quantity',
        'product_description',
        'category_id',
        'inactive',
        'position'
    ];

    public function getCreatedAtAttribute()
    {
        return  Carbon::parse($this->attributes['created_at'])->format('d.M.Y.');
    }
    // Belogns to category
    public function categories()
    {
        return $this->belongsTo('App\Category', 'category_id','id');
    }

    // Belogns to order
    public function orders()
    {
        return $this->belongsTo('App\Order');
    }

}
