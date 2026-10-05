<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StorePlanRequest;
use App\Http\Requests\UpdatePlanRequest;
use App\Plan;
use App\Workout;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class PlansController extends Controller
{
    protected $plans, $workouts;

    public function __construct(Plan $plans, Workout $workouts)
    {
        $this->plans = $plans;
        $this->workouts     = $workouts;

        parent::__construct();
    }

    public function index()
    {
        return view('admin.plans.index');
    }

    public function plansData()
    {
        $plans = $this->plans->with('workout')->get();

        return DataTables::of($plans)
            ->addColumn('action0', function($plans) {
                return view('admin.plans.action0', compact('plans'))->render();
            })
            ->addColumn('action1', function($plans) {
                return view('admin.plans.action1', compact('plans'))->render();
            })
            ->addColumn('action2', function($plans) {
                return view('admin.plans.action2', compact('plans'))->render();
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['action0','action1','action2'])
            ->make(true);

    }


    public function create(Plan $plans)
    {
        $workouts = $this->workouts->get();

        return view('admin.plans.form', compact('plans', 'workouts'));
    }


    public function store(StorePlanRequest $request)
    {
        $this->plans->fill($request->only('workout_id','name', 'workouts_number', 'plan_duration', 'price'))->save();

        flash()->overlay(trans('flash.success'),trans('flash.plans.screated'));

        return redirect(route('admin.plans.index'));
    }


    public function edit($id)
    {
        $plans = $this->plans->findOrfail($id);

        $workouts = $this->workouts->get();

        return view('admin.plans.form', compact('plans', 'workouts'));
    }

    public function update(UpdatePlanRequest $request, $id)
    {
        $plans = $this->plans->findOrfail($id);

        $plans->fill($request->only('workout_id','name', 'workouts_number', 'plan_duration', 'price'))->save();

        flash()->overlay(trans('flash.success'),trans('flash.plans.supdated'));

        return redirect(route('admin.plans.index'));
    }

    public function updateSeen(Request $request, $id)
    {

        if($request->ajax()){
            $plans = $this->plans->findOrFail($id);
            $plans->seen = $request->get('seen') == 'true';
            $plans->save();

            return response()->json(['statut' => 'ok']);
        }

    }


    public function destroy($id)
    {
        $this->plans->findOrfail($id)->delete();

        flash()->overlay(trans('flash.success'),trans('flash.plans.sdeleted'));

        return redirect(route('admin.plans.index'));
    }

}
