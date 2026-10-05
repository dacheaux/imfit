<?php

namespace App\Http\Controllers;

use App\Page;
use App\Photo;
use App\Post;
use Illuminate\Http\Request;

class HomeController extends Controller
{

    protected $photos;
    protected $page;

    public function __construct(Photo $photos, Page $page)
    {
        $this->photos = $photos;
        $this->page = $page;
    }

    public function index()
    {

        return view('pages.index');
    }

    public function about()
    {
        return view('pages.about');
    }

    public function gallery()
    {
        $photos = $this->photos->where('photo_id', 1)->orderBy('order')->get();

        return view('pages.gallery', compact('photos'));
    }

    public function singlePciture($id)
    {
        $picture = $this->photos->findOrFail($id);

        return view('pages.picture', compact('picture'));
    }

    public function blog()
    {
        return view('pages.blog');
    }
      public function blogSingle()
    {
        return view('pages.single-blog');
    }
    public function contact()
    {
        return view('pages.contact');
    }

}
