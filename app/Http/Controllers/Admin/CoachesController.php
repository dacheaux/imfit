<?php

namespace App\Http\Controllers\Admin;

use App\Term;
use App\User;
use App\Workout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Kalnoy\Nestedset\Collection;
use Yajra\DataTables\DataTables;

class CoachesController extends Controller
{
    protected $users, $terms, $workouts;

    public function __construct(User $users, Term $terms, Workout $workouts)
    {
        $this->workouts = $workouts;
        $this->users = $users;
        $this->terms = $terms;

        parent::__construct();
    }

    public function index()
    {
//        $trenerId = "trener_id";
//        $from = Carbon::now()->subDays(30);
//        $to = Carbon::now();
//
//        $terms = $this->terms->where('trener_id', $trenerId)->whereBetween('end_datetime', [ $from, $to ])
//            ->with('coaches')->with(['userTerms' => function($q){
//                $q->where('delayed', 0);
//        }])->get();
//
//        return $terms;

        $workouts = $this->workouts->get();
        $coaches = User::role('trener')->get();

       return view('admin.coaches.index', compact('coaches', 'workouts'));
    }

    public function dataCoaches(Request $request)
    {
        $from = Carbon::now()->subDays(30);
        $to = Carbon::now();

        $terms = $this->terms
            ->where(function($q) use ($request){
                if( $request->get('trener_id') != null){
                    $q->where('trener_id', '=', $request->get('trener_id'));
                }
                if( $request->get('workout_id') != null){
                    $q->where('workout_id', '=', $request->get('workout_id'));
                }
            })
            ->whereBetween('end_datetime', [ $request->get('from') != null ? Carbon::parse($request->get('from')) : $from, $request->get('to') != null ? Carbon::parse($request->get('to')) : $to])
            ->with('coaches')->with('workout')->with(['userTerms' => function($q){
                $q->where('user_delayed', 0);
        }])->get();

        $data = new Collection();

        foreach ($terms as $index => $v){
            if( count($terms[$index]->userTerms) > 0){
                $data->push([
                    'id'   => $v->id,
                    'coach'       => $terms[$index]->coaches[0]->name .' '. $terms[$index]->coaches[0]->lastname,
                    'workout'       => $terms[$index]->workout->name,
                    'user_terms'       => count($terms[$index]->userTerms),
                    'start_datetime'       => $v->start_datetime->format('d.m.Y H:i'),
                ]);
            }
        }

        if(count($data) > 0){
            $sum = $data->sum('user_terms');
        }else{
            $sum = 0;
        }


        return DataTables::of($data)
            ->editColumn('id', '{{$id}}')
            ->addColumn('actions', function($data){
                $terms = route('admin.terms.show', $data['id']);
                return view('admin.coaches.actions', compact('terms'));
            })
            ->addColumn('total_users', function ($data) use ($sum){
                return $sum;
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

}
