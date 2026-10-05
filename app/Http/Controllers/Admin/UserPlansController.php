<?php

namespace App\Http\Controllers\Admin;

use App\Notifications\ApprovedPlanNotification;
use App\Plan;
use App\Term;
use App\User;
use App\UserPlan;
use App\UserTerm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class UserPlansController extends Controller
{

    protected $userplans, $user, $terms, $userTerms, $plans;

    public function __construct(UserPlan $userplans, User $user, Term $terms, UserTerm $userTerms, Plan $plans)
    {
        $this->userplans = $userplans;
        $this->terms = $terms;
        $this->user = $user;
        $this->plans = $plans;
        $this->userTerms = $userTerms;

        parent::__construct();
    }

    public function index()
    {
        $plans = $this->plans->all();

        return view('admin.userplans.index', compact('plans'));
    }

    public function userplansData(Request $request)
    {
        $userplans = $this->userplans
            ->where(function($q) use ($request){
                if( $request->get('plan_id') != null){
                    $q->where('plan_id', '=', $request->get('plan_id'));
                }
                if( $request->get('paid') != null){
                    $q->where('paid', '=', $request->get('paid'));
                }
                if( $request->get('expired_time') != null){
                    $q->where('expired_time', '>',Carbon::now());
                    $q->where('expired_time', '<=',Carbon::now()->addDays($request->get('expired_time')));
                }

            })
            ->with('plan')->with('user')->latest();

        return DataTables::of($userplans)
            ->addColumn('date', function($userplans) {
                return view('admin.userplans.date', compact('userplans'))->render();
            })
            ->addColumn('approved', function($userplans) {
                return view('admin.userplans.approved', compact('userplans'))->render();
            })
            ->addColumn('paid', function($userplans) {
                return view('admin.userplans.paid', compact('userplans'))->render();
            })
            ->addColumn('active', function($userplans) {
                return view('admin.userplans.active', compact('userplans'))->render();
            })
            ->addColumn('pause', function($userplans) {
                return view('admin.userplans.pause', compact('userplans'))->render();
            })
            ->addColumn('action1', function($userplans) {
                return view('admin.userplans.action1', compact('userplans'))->render();
            })
            ->addColumn('action2', function($userplans) {
                return view('admin.userplans.action2', compact('userplans'))->render();
            })
              ->addColumn('action3', function($userplans) {
                return view('admin.userplans.action3', compact('userplans'))->render();
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['date','approved','paid','active','pause','action3','action2','action1'])
            ->make(true);

    }

    public function create(UserPlan $userplans)
    {
        $plans = $this->plans->get();

        $vezbaci = User::role('vežbač')->orderBy('created_at','desc')->get();

        return view('admin.userplans.create', compact('plans', 'vezbaci', 'userplans'));
    }

    public function store(Request $request)
    {
        $plan = $this->plans->find($request->get('plan_id'));

        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
            'user_id' => 'required|exists:users,id',
        ]);
        if (!$validator->fails()) {
            $userPlan = new UserPlan();
            $userPlan->plan_id = $request->get('plan_id');
            $userPlan->user_id = $request->get('user_id');
            $userPlan->terms_number = $plan->workouts_number;
            $userPlan->expired_time = Carbon::now();
            $userPlan->save();

            flash()->overlay('Uspešno!', 'Plan je uspešno primenjen.', 'success');

            return redirect()->route('admin.userplans.index');
        }

        flash()->overlay('Greška!', implode('', $validator->errors()->all('<li>:message</li>')), 'error');

        return redirect()->back()->withInput()->withErrors($validator->errors());
    }

    public function edit($id)
    {
        $userplans = $this->userplans->with('plan')->findOrFail($id);

        return view('admin.userplans.edit', compact('userplans'));
    }
    public function update(Request $request, $id){

        $userplans = $this->userplans->findOrFail($id);

        $userplans->terms_number = $request->get('terms_number');
        $userplans->expired_time = Carbon::parse($request->get('expired_time'));
        $userplans->save();

        flash()->overlay(trans('flash.success'),trans('flash.userplans.updated'));

        return redirect()->back();
    }

    public function updatePauseOn(Request $request, $id){

        $userplans = $this->userplans->with('plan')->where('user_id', $request->get('user_id'))->findOrFail($id);

        if($userplans->active && !$userplans->pause_flag){
            $userplans->pause_flag = 1;
            $userplans->pause_from =  Carbon::now();
        }else{
            flash()->overlay('Upozorenje!', 'Plan je nije aktiviran.', 'info');
            return redirect()->back();
        }

        $userplans->update();

        flash()->overlay(trans('flash.success'),trans('flash.userplans.spausedon'));

        return redirect()->back();
    }
    public function updatePauseOff(Request $request, $id){

        $userplans = $this->userplans->where('user_id', $request->get('user_id'))->findOrFail($id);
        $userplans->pause_flag = 0;
        $userplans->pause_time =  Carbon::now();
        $userplans->expired_time = Carbon::now()->addDays( $userplans->pause_from->diffInDays($userplans->expired_time) );
        $userplans->update();

        flash()->overlay(trans('flash.success'),trans('flash.userplans.spausedoff'));

        return redirect()->back();
    }

    public function updatePlan(Request $request, $id)
    {
        $userplans = $this->userplans->with('plan')->findOrFail($id);

        if($request->get('approved') ){
            $userplans->approved = $request->get('approved') == 'true';
            $user = $this->user->findOrFail($userplans->user_id);
            $user->notify( new ApprovedPlanNotification($user) );
        }
        if($request->get('paid') ) {
            $userplans->paid = $request->get('paid') == 'true';
        }
        if($request->get('active') ){
            if(!$userplans->active && $userplans->approved ) {
                $userplans->active = $request->get('active') == 'true';
                $userplans->expired_time = Carbon::now()->addDays($userplans->plan->plan_duration);
            }else{
                return response()->json(['statut' => 'nije odobren']);
            }

        }
        if($request->get('pause_flag') ){
            if($userplans->active && !$userplans->pause_flag){
                $userplans->pause_flag = $request->get('pause_flag') == 'true';
                $userplans->pause_time =  Carbon::now()->addDays(config('settings.time_pause'));
                $userplans->expired_time =  $userplans->expired_time->addDays(config('settings.time_pause'));
            }else{
                return response()->json(['statut' => 'nije aktivan']);
            }
        }

        $userplans->save();

        return response()->json(['statut' => 'ok']);
    }

    public function destroy($id)
    {
        $this->userplans->findOrfail($id)->delete();

        flash()->overlay(trans('flash.success'),trans('flash.userplans.sdeleted'));

        return redirect(route('admin.userplans.index'));
    }

}
