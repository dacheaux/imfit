<?php

namespace App\Http\ViewComposers;

use App\Repositories\Eloquent\EloquentCategoryRepository;
use Illuminate\View\View;


class CategoriesComposer
{

    protected $category;


    public function __construct(EloquentCategoryRepository $category)
    {
        $this->category = $category;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('categories', $this->category->with('categories')->get());
    }
}
