<?php

namespace App\Http\ViewComposers;

use App\Repositories\Eloquent\EloquentPostRepository;
use Illuminate\View\View;


class PostsComposer
{

    protected $posts;


    public function __construct(EloquentPostRepository $posts)
    {
        $this->posts = $posts;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('posts', $this->posts->all()->take(3));
    }
}