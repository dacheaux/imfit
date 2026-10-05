<?php

namespace App\Http\ViewComposers;

use App\Repositories\Eloquent\EloquentTagRepository;
use Illuminate\View\View;


class TagsComposer
{

    protected $tags;


    public function __construct(EloquentTagRepository $tags)
    {
        $this->tags = $tags;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('tags', $this->tags->orderBy('count', 'desc')->get());
    }
}