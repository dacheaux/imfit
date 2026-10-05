<?php

namespace App\Repositories\Eloquent;


use App\Category;
use App\Repositories\Contracts\CategoryRepository;

use Conner\Tagging\Model\Tag;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentCategoryRepository extends AbstractRepository implements CategoryRepository
{
    public function entity()
    {
        return Category::class;
    }

    public function orderBy($name, $ordering)
    {
        return Category::orderBy($name, $ordering);
    }
    public function with($name)
    {
        return Category::with($name);
    }
}
