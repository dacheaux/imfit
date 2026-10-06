<?php

namespace App\Traits;

use App\Comment;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphMany;

trait HasComments
{
    public function comments(): MorphMany
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

    public function comment(array $data, Model $creator, Model $parent = null)
    {
        $comment = (new Comment())->fill(array_merge($data, [
            'creator_id' => $creator->getKey(),
            'creator_type' => $creator->getMorphClass(),
            'parent_id' => $parent ? $parent->getKey() : null,
        ]));

        $this->comments()->save($comment);

        return $comment;
    }

    public function commentCount(): int
    {
        return $this->comments()->count();
    }
}
