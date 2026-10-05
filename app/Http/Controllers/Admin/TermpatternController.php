<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreTermPatternsRequest;
use App\Http\Requests\UpdateTermPatternsRequest;
use App\Term;
use App\Termpattern;
use App\User;
use App\Workout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class TermpatternController extends Controller
{
    protected $termpattern, $workouts;

    public function __construct(Termpattern $termpattern, Workout $workouts)
    {
        $this->termpattern = $termpattern;
        $this->workouts = $workouts;

        parent::__construct();
    }


    public function index()
    {
        return view('admin.termpatterns.index');
    }

    public function create(Termpattern $termpattern)
    {
        $workouts = $this->workouts->get();

        $coaches = User::role('trener')->get();

        return view('admin.termpatterns.form', compact('workouts', 'termpattern', 'coaches'));
    }

    public function edit($id)
    {
        $termpattern = $this->termpattern->findOrFail($id);
        //dd(unserialize($termpattern->hours));
        $coaches = User::role('trener')->get();
        $workouts = $this->workouts->get();

        return view('admin.termpatterns.form', compact('termpattern','workouts', 'coaches'));
    }

    public function update($id, UpdateTermPatternsRequest $request)
    {
        $termpattern = $this->termpattern->findOrFail($id);
        $termpattern->fill($request->only(['name','workout_id', 'trener_id', 'slots', 'note']));

        $arr = [];
        foreach ( $request->get('hours') as $h ){
            $arr[] = Carbon::parse($h);
        }
        $termpattern->hours = serialize($arr);
        $termpattern->save();

        flash()->overlay(trans('flash.success'),trans('flash.termpatterns.supdated'));

        return redirect()->back();
    }

    public function store(StoreTermPatternsRequest $request)
    {

        $termpattern = $this->termpattern->fill($request->only(['name','workout_id', 'trener_id', 'slots', 'note']));

        $arr = [];
        foreach ( $request->get('hours') as $h ){
            $arr[] = Carbon::parse($h);
        }

        $termpattern->hours = serialize($arr);
        $termpattern->save();

        flash()->overlay(trans('flash.success'),trans('flash.termpatterns.screated'));

        return redirect()->back();
    }

    public function termpatternsData()
    {
        $termpattern = $this->termpattern->with('workout')->with('coach')->get();

        return DataTables::of($termpattern)
            ->addColumn('action0', function($termpattern) {
                return view('admin.termpatterns.action0', compact('termpattern'))->render();
            })
            ->addColumn('action1', function($termpattern) {
                return view('admin.termpatterns.action1', compact('termpattern'))->render();
            })
            ->editColumn('coach.name', function($termpattern) {
                return $termpattern->coach->name . ' '. $termpattern->coach->lastname;
            })
            ->editColumn('created_at', function($termpattern) {
                return Carbon::parse($termpattern->created_at)->format('d.m.Y.');
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['action0','action1'])
            ->make(true);

    }


    public function destroy($id)
    {
        $this->termpattern->findOrFail($id)->delete();

        flash()->overlay(trans('flash.success'),trans('flash.termpatterns.sdeleted'));

        return redirect(route('admin.termpatterns.index'));
    }

}
