<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;

class BlogServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        View::composer(
            'partials.shop-sidebar', 'App\Http\ViewComposers\CategoriesComposer'
        );

         View::composer(
            'partials.blog-sidebar', 'App\Http\ViewComposers\TagsComposer'
        );

        View::composer(
            'partials.blog-sidebar', 'App\Http\ViewComposers\PostsComposer'
        );

        View::composer(
            'pages.index', 'App\Http\ViewComposers\PostsComposer'
        );
        View::composer(
            'partials.footer', 'App\Http\ViewComposers\PhotosComposer'
        );
    }

    /**
     * Register services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
