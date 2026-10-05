<?php

namespace App\Http\Controllers;

use App\Post;
use App\User;
use Conner\Tagging\Model\Tag;
use Illuminate\Http\Request;

class PostsController extends Controller
{
    protected $posts;
    protected $user;

    public function __construct(Post $posts, User $user)
    {
        $this->posts = $posts;
        $this->user = $user;

        $this->middleware('auth')->only(['postComment', 'postReply']);
    }

    public function index(Request $request)
    {
        $posts = $this->posts->whereActive(1)->latest()->paginate(8);

        if($request->ajax()){
            return [
                'posts' => view('front.posts.ajaxposts',  compact('posts', $posts))->render(),
                'next_page' => $posts->nextPageUrl()
            ];
        }

        return view('posts.index', compact('posts', $posts));
    }

    public function getByTag(Request $request, $slug)
    {
        $posts = $this->posts->withAnyTag($slug)->whereActive(1)->latest()->paginate(8);

        if($request->ajax()){
            return [
                'posts' => view('front.posts.ajaxposts',  compact('posts', $posts))->render(),
                'next_page' => $posts->nextPageUrl()
            ];
        }

        return view('posts.index', compact('posts', $posts));
    }

    public function searchByTermPaginated(Request $input, $perPage = 8)
    {
        $term     = $input->get('q');
        $products = null;
        $search_terms = explode(' ', $term);

        $posts = Post::where(function ($q) use ($search_terms) {
            foreach ($search_terms as $keyword) {
                if ($keyword != '') {
                    $q->orWhere('post_title', 'LIKE', '%' . $keyword . '%')
                      ->orWhere('post_body', 'LIKE', '%' . $keyword . '%');
                }
            }
        })->whereActive(1)->latest()->paginate($perPage);

        if($input->ajax()){
            return [
                'posts' => view('front.posts.ajaxposts',  compact('posts', $posts))->render(),
                'next_page' => $posts->nextPageUrl()
            ];
        }

        return view('posts.result', compact('posts','term'));

    }

    public function show($slug)
    {
        $post = $this->posts->with('tagged')->where('slug', $slug)->firstOrFail();

        return view('posts.show', compact('post'));
    }

    public function postComment(Request $request, $id)
    {
        $post = $this->posts->findOrFail($id);

        $comment = $post->comment([
            'title' => auth()->user()->name,
            'body' => $request->body
        ], auth()->user() );

        return redirect()->back();
    }

    public function postReply(Request$request, $id, $comid)
    {
        $post = $this->posts->findOrFail($id);

        $parent = $post->comments()->find($comid);

        $comment = $post->comment([
            'title' => 'Some title',
            'body' => $request->body
        ], auth()->user(), $parent );

        return redirect()->back();
    }
}
