<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StorePostRequest;
use App\Http\Requests\UpdatePostRequest;
use App\Post;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Intervention\Image\Facades\Image;
use Yajra\DataTables\Facades\DataTables;

class PostsController extends Controller
{
    protected $posts;

    public function __construct(Post $posts)
    {
        $this->posts = $posts;

        parent::__construct();
    }

    public function index()
    {
        return view('admin.posts.index');
    }

    public function postsData()
    {
        $posts = $this->posts->with('tagged')->get();

        return DataTables::of($posts)
            ->addColumn('action2', function($posts) {
                return view('admin.posts.action2', compact('posts'))->render();
            })
            ->addColumn('action', function($posts) {
                return view('admin.posts.action', compact('posts'))->render();
            })
            ->addColumn('action0', function($posts) {
                return view('admin.posts.action0', compact('posts'))->render();
            })
            ->addColumn('action1', function($posts) {
                return view('admin.posts.action1', compact('posts'))->render();
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->rawColumns(['action','action0', 'action1', 'action2'])
            ->make(true);

    }

    public function searchTags(Request $request)
    {
        $tags = DB::table('tagging_tags')->where('name','like','%'.$request->input('keyword').'%')->get();

        return json_encode($tags);
    }

    public function getTags(Request $request)
    {
        $tags = DB::table('tagging_tagged')->where('taggable_id', $request->input('id') )->get();

        return json_encode($tags);
    }

    public function updateActive(Request $request, $id){
        if($request->ajax()){
           $posts = $this->posts->findOrFail($id);
            if($request->get('active')){
                $posts->active = $request->get('active') == 'true';
            }
            $posts->save();

            return response()->json(['statut' => 'ok']);
        }
    }

    public function update(UpdatePostRequest $request, $id)
	{
        $post = $this->posts->findOrfail($id);

        $post->fill($request->only('post_title', 'slug', 'post_desc', 'post_body', 'active'));

         if($request->hasFile('post_image')) {

             $post_image = $request->file('post_image');
             $filename = time() . '.' . $post_image->getClientOriginalExtension();

             Image::make($post_image)->save(public_path('/uploads/posts/' . $filename));
             Image::make($post_image)->fit(510, 340)->save(public_path('/uploads/posts-thumb/' .'tb_'. $filename));

             if (\File::exists(public_path() . $post->post_image)) {
                 \File::delete(public_path() . $post->post_image);
                 \File::delete(public_path() . $post->post_thumb);
             }
             $post->post_image = '/uploads/posts/'.$filename;
             $post->post_thumb = '/uploads/posts-thumb/'.'tb_'.$filename;
         }

        if($request->input('posts_tags') != null){
            $post->retag($request->input('posts_tags'));
        }else{
            $post->untag();
        }


         $post->save();

        flash()->overlay(trans('flash.success'),trans('flash.posts.supdated'));

        return redirect(route('admin.posts.index'));

	}

    public function create(Post $post)
    {
        return view('admin.posts.form', compact('post'));
    }


    public function store(StorePostRequest $request){

        $post = $this->posts->fill(
            ['user_id' => auth()->user()->id ] +
            $request->only('post_title', 'slug', 'post_desc', 'post_body', 'active')
        );

        if($request->hasFile('post_image')) {

            $post_image = $request->file('post_image');
            $filename = time() . '.' . $post_image->getClientOriginalExtension();

            Image::make($post_image)->save(public_path('/uploads/posts/' . $filename));
            Image::make($post_image)->fit(510, 340)->save(public_path('/uploads/posts-thumb/' .'tb_'. $filename));

            if (\File::exists(public_path() . $post->post_image)) {
                \File::delete(public_path() . $post->post_image);
                \File::delete(public_path() . $post->post_thumb);
            }
            $post->post_image = '/uploads/posts/'.$filename;
            $post->post_thumb = '/uploads/posts-thumb/'.'tb_'.$filename;
        }

        $post->save();

        if($request->input('posts_tags') != null){
            $post->tag($request->input('posts_tags'));
        }

        flash()->overlay(trans('flash.success'),trans('flash.posts.screated'));

        return redirect(route('admin.posts.index'));
    }

    public function edit($id)
    {

        $post = $this->posts->with('tagged')->findOrFail($id);


        return view('admin.posts.form', compact('post'));
    }


    public function destroy($id)
    {
        $post = $this->posts->findOrFail($id);

         if (\File::exists(public_path() . $post->post_image)) {
             \File::delete(public_path() . $post->post_image);
             \File::delete(public_path() . $post->post_thumb);
         }

        $post->untag();

        $post->delete();

        flash()->overlay(trans('flash.success'),trans('flash.posts.sdeleted'));

        return redirect(route('admin.posts.index'));
    }

    public function imageDelete(Request $request){

        if($request->ajax()){
             $post = $this->posts->findOrFail($request->get('post_id'));

             if (\File::exists(public_path() . $post->post_image)) {
                 \File::delete(public_path() . $post->post_image);
                 \File::delete(public_path() . $post->post_thumb);
                 $post->post_image = null;
                 $post->post_thumb = null;
                 $post->save();
             }
             return response('{}', 200);
        }

    }


}
