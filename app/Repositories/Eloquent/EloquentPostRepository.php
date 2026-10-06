<?php

namespace App\Repositories\Eloquent;

use App\Post;
use App\Repositories\Contracts\PostRepository;

use App\Repositories\Eloquent\AbstractRepository;

class EloquentPostRepository extends AbstractRepository implements PostRepository
{
    public function entity()
    {
        return Post::class;
    }
}
