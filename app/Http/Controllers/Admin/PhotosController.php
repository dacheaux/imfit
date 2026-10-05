<?php

namespace App\Http\Controllers\Admin;

use App\Page;
use App\Photo;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;
use Illuminate\Http\UploadedFile;

class PhotosController extends Controller
{
    protected $photo, $page;

    public function __construct(Photo $photo, Page $page)
    {

        $this->page = $page;
        $this->photo = $photo;

        parent::__construct();
    }

    public function index()
    {
        $pages = $this->page->where('gallery', 1)->pluck('name', 'id')->toArray();

        return view('admin.photos.index', compact('pages'));
    }


    public function photosData(Request $request)
    {

        if($request->ajax()) {

            $photo = $this->photo->where('photo_id', $request->get('photo_id'))->orderBy('order')->get();

            return DataTables::of($photo)
                ->addColumn('thumb', function ($photo) {
                    return view('admin.photos.thumb', compact('photo'))->render();
                })
                ->addColumn('action0', function ($photo) {
                    return view('admin.photos.action0', compact('photo'))->render();
                })
                ->addColumn('action1', function ($photo) {
                    return view('admin.photos.action1', compact('photo'))->render();
                })
                ->addColumn('responsive', function ($photo) {
                    return view('admin.photos.responsive', compact('photo'))->render();
                })
                ->editColumn('order', '<i class="fa fa-arrows-alt" aria-hidden="true"></i>')
                ->rawColumns(['order','thumb', 'action0', 'action1', 'responsive'])
                ->make(true);
        }
    }

    public function reorderData(Request $request)
    {
        $count = 0;

        if (count($request->json()->all())) {
            $ids = $request->json()->all();
            foreach($ids as $i => $key)
            {
                $id = $key['id'];
                $position = $key['position'];

                $photo = $this->photo->find($id);

                $photo->order = $position;
                if($photo->save())
                {
                    $count++;
                }
            }
            return response()->json(['statut' => 'ok']);
        }

    }

    public function store(Request $request)
    {

        if($request->ajax()){

            $countOrder = $this->photo->where('photo_id', $request['photoId'])->count();

            $photo = $this->makePhoto($request['path']);

            $photo->photo_id = (int) $request['photoId'];
            $photo->title = $request['title'];
            $photo->description = $request['description'];
            $photo->order = $countOrder + 1;

            $photo->save();

            return response()->json(['statut' => 'ok']);
        }

         return redirect(route('admin.photos.index'));
    }

    public function makePhoto(UploadedFile $file)
    {

        return Photo::named($file->getClientOriginalName())
                    ->move($file);
    }

    public function edit($id)
    {
        $photo = $this->photo->findOrFail($id);

       return view('admin.photos.form', compact('photo'));
    }

    public function editPhoto(Request $request)
    {
        if($request->ajax()){

            $photo = $this->photo->findOrFail($request->get('id'));

            return response()->json($photo);

        }
    }

    public function destroyPhoto(Request $request)
    {
        if($request->ajax()) {

            $photo = $this->photo->findOrFail($request->get('id'));
             if($photo->path != 'gallery/photos/no-image.png'){
                if (\File::exists(public_path() . '/' . $photo->path)) {
                    \File::delete(public_path() . '/' . $photo->path);
                    \File::delete(public_path() . '/' . $photo->thumbnail_path);
                }
             }

            $photo->delete();
        }

        //flash()->overlay(trans('flash.success'),trans('flash.photos.pdeleted'));

        //return redirect(route('admin.photos.index'));
    }

    public function imageDelete(Request $request){

        if($request->ajax()){

             $photo = $this->photo->findOrFail($request->get('photo_id'));

              if (\File::exists(public_path().'/'. $photo->baseDir . $photo->path)) {
                  if($photo->path != 'gallery/photos/no-image.png'){
                    \File::delete(public_path().'/' .$photo->baseDir . $photo->path);
                    \File::delete(public_path().'/' .$photo->baseDir . $photo->thumbnail_path);
                     $photo->path =  'gallery/photos/no-image.png';
                     $photo->thumbnail_path = 'gallery/photos/tn-no-image.png';
                     $photo->save();
                  }
             }
             return response('{}', 200);
        }

    }


}
