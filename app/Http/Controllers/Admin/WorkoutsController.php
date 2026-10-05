<?php

namespace App\Http\Controllers\Admin;

use App\Workout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests\StoreWorkoutRequest;
use App\Http\Requests\UpdateWorkoutRequest;

class WorkoutsController extends Controller
{

    protected $workouts;

    public function __construct(Workout $workouts)
    {
        $this->workouts = $workouts;

        parent::__construct();
    }


    public function index()
    {
       return view('admin.workouts.index');
    }

    public function workoutsData()
    {
        $workouts = $this->workouts->get();

        return DataTables::of($workouts)
            ->addColumn('action0', function($workouts) {
                return view('admin.workouts.action0', compact('workouts'))->render();
            })
            ->addColumn('action1', function($workouts) {
                return view('admin.workouts.action1', compact('workouts'))->render();
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['action0','action1'])
            ->make(true);

    }


    public function create(Workout $workouts)
    {
      return view('admin.workouts.form', compact('workouts'));
    }


    public function store(StoreWorkoutRequest $request)
    {
        $this->workouts->fill($request->only('name', 'workout_time'))->save();

        flash()->overlay(trans('flash.success'),trans('flash.workouts.screated'));

        return redirect(route('admin.workouts.index'));
    }


    public function edit($id)
    {
        $workouts = $this->workouts->findOrfail($id);

        return view('admin.workouts.form', compact('workouts'));
    }

    public function update(UpdateWorkoutRequest $request, $id)
    {
        $workouts = $this->workouts->findOrfail($id);

        $workouts->fill($request->only('name', 'workout_time'))->save();

        flash()->overlay(trans('flash.success'),trans('flash.workouts.supdated'));

        return redirect(route('admin.workouts.index'));
    }


    public function destroy($id)
    {
        $this->workouts->findOrfail($id)->delete();

        flash()->overlay(trans('flash.success'),trans('flash.workouts.sdeleted'));

        return redirect(route('admin.workouts.index'));
    }
}
