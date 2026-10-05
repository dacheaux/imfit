<?php

namespace App\Repositories\Eloquent;


use App\Repositories\Contracts\TagRepository;

use Conner\Tagging\Model\Tag;
use Kurt\Repoist\Repositories\Eloquent\AbstractRepository;

class EloquentTagRepository extends AbstractRepository implements TagRepository
{
    public function entity()
    {
        return Tag::class;
    }

    public function orderBy($name, $ordering)
    {
        return Tag::orderBy($name, $ordering);
    }
}
