<?php

namespace App\Repositories\Eloquent;

use App\Photo;
use App\Repositories\Contracts\PhotosRepository;
use App\Repositories\Contracts\PostRepository;

use App\Repositories\Eloquent\AbstractRepository;

class EloquentPhotosRepository extends AbstractRepository implements PhotosRepository
{
    public function entity()
    {
        return Photo::class;
    }
}
