<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTagsRequest;
use App\Http\Requests\UpdateTagsRequest;
use App\Post;
use Conner\Tagging\Model\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\Facades\DataTables;

class TagsController extends Controller
{
    protected $tags;
    protected $posts;

    public function __construct(Tag $tags, Post $posts)
    {
        $this->tags = $tags;
        $this->posts = $posts;

        parent::__construct();
    }

    public function index()
    {
        return view('admin.tags.index');
    }

    public function tagsData()
    {
        $tags = $this->tags->get();

        return DataTables::of($tags)
            ->addColumn('action0', function($tags) {
                return view('admin.tags.action0', compact('tags'))->render();
            })
            ->addColumn('action1', function($tags) {
                return view('admin.tags.action1', compact('tags'))->render();
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['action0','action1'])
            ->make(true);

    }

    public function create(Tag $tags)
    {
      return view('admin.tags.form', compact('tags'));
    }

    public function store(StoreTagsRequest $request)
    {
        $this->tags->fill($request->only('name'))->save();

        flash()->overlay(trans('flash.success'),trans('flash.tags.screated'));

        return redirect(route('admin.tags.index'));
    }

    public function edit($id)
    {
        $tags = $this->tags->findOrfail($id);

        return view('admin.tags.form', compact('tags'));
    }

    public function update(UpdateTagsRequest $request, $id)
    {
        $tag = $this->tags->findOrfail($id);

        $posts = $this->posts->withAnyTag($tag->name)->get();

         foreach ($posts as $p){
           $p->untag($tag->name);
        }

        $tag->fill($request->only('name'))->save();


        flash()->overlay(trans('flash.success'),trans('flash.tags.supdated'));

        return redirect(route('admin.tags.index'));
    }

    public function destroy($id)
    {
        $tag = $this->tags->findOrfail($id);

        DB::table('tagging_tagged')->where('tag_slug', $tag->slug)->delete();

        $tag->delete();


        flash()->overlay(trans('flash.success'),trans('flash.tags.sdeleted'));

        return redirect(route('admin.tags.index'));
    }
}
