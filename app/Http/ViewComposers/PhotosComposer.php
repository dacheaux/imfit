<?php

namespace App\Http\ViewComposers;

use App\Repositories\Eloquent\EloquentPhotosRepository;
use Illuminate\View\View;


class PhotosComposer
{

    protected $photos;


    public function __construct(EloquentPhotosRepository $photos)
    {
        $this->photos = $photos;
    }

    /**
     * Bind data to the view.
     *
     * @param  View  $view
     * @return void
     */
    public function compose(View $view)
    {
        $view->with('photos', $this->photos->all()->take(6));
    }
}