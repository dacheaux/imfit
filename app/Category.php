<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'categories';

    protected $fillable = ['category_name',  'category_slug', 'parent_id', 'visible', 'sorting'];

    public function categories()
    {
        return $this->hasMany(Category::class, 'parent_id', 'id')->orderBy('sorting', 'ASC');
    }

    public function products()
    {
        return $this->hasMany('App\Product', 'category_id');
    }
}
