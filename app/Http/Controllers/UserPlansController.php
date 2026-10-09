<?php

namespace App\Http\Controllers;

use App\Mail\NewPlanMail;
use App\Plan;
use App\Term;
use App\User;
use App\UserPlan;
use App\UserTerm;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Notifications\Notification;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class UserPlansController extends Controller
{

    protected $usersPlans, $plans, $userTerms, $terms;

    public function __construct(UserPlan $usersPlans, Plan $plans, UserTerm $userTerms, Term $terms)
    {
        $this->usersPlans = $usersPlans;
        $this->plans = $plans;
        $this->userTerms = $userTerms;
        $this->terms = $terms;
        $this->middleware(['role:vežbač', 'auth']);
        parent::__construct();
    }


    public function index()
    {
       $userPlans = $this->usersPlans->where('user_id', auth()->id())->with('plan')->orderBy('created_at', 'desc')->paginate(10);
       $plans = $this->plans->whereSeen(0)->with('workout')->get();

        return view('pages.paketi', compact('userPlans', 'plans'));
    }


    public function getStoreTime(){
        // Get hos for key
        $host = gethostname();
        // Using -1 for $last_update will always ensure that the next line is true if no entry exists
        $last_update = Session::has($host) ? Session::get($host) : -1;

        // If no entry exists (-1), then the below statement will always be true!
        $allow_entry = Carbon::now()->timestamp >=  $last_update ? true : false;

        return $allow_entry;

    }

    public function store(Request $request){

        $host = gethostname();

        $plan = $this->plans->findOrFail($request->get('plan_id'));

        $validator = Validator::make($request->all(), [
            'plan_id' => 'required|exists:plans,id',
        ]);

        if (!$validator->fails()) {
            if ($this->getStoreTime()) {

                $emails = ['admin@imfit.rs'];

                Mail::to($emails)->send(new NewPlanMail($plan, auth()->user() ));

                // Only update the Session if an entry was inserted
                Session::put($host, Carbon::now()->addMinute()->timestamp);

                $userPlan = new UserPlan();
                $userPlan->plan_id = $request->get('plan_id');
                $userPlan->user_id = auth()->id();
                $userPlan->terms_number = $plan->workouts_number;
                $userPlan->expired_time = Carbon::now();
                $userPlan->save();

                flash()->overlay('Poslato!', 'Paket je uspešno poručen.<br> Obavestićemo Vas kada paket bude odobren. <br> <span style=\"font-weight: 600;\">Molimo Vas da članarinu platite unapred. <br>Hvala.</span>', 'success');

                return redirect()->back();
            }

             flash()->overlay('Upozorenje!', 'Prethodna porudžbina je već poslata, pokušajte ponovo kasnije. Hvala.', 'info');

            return redirect()->back()->withInput();
        }

         flash()->overlay('Greška!', implode('', $validator->errors()->all('<li>:message</li>')), 'error');

        return redirect()->back()->withInput()->withErrors($validator->errors());
    }


    public function activatePlan(Request $request)
    {
        $userplans = $this->usersPlans->with('plan')->where('user_id', auth()->id())->findOrFail($request->get('id'));

        if(!$userplans->active && $userplans->approved ) {
            $userplans->active = 1;
            $userplans->expired_time = Carbon::now()->addDays($userplans->plan->plan_duration);
        }else{
            flash()->overlay('Upozorenje!', 'Paket je nije odobren. Pokušajte ponovo kasnije. Hvala.', 'info');
            return redirect()->back();
        }

        $userplans->save();

        flash()->overlay('Paket aktiviran!', 'Paket ističe: '.$userplans->expired_time->format('d.M.Y.') , 'success');

        return redirect()->back();
    }
//    public function pausePlan(Request $request)
//    {
//        $userplans = $this->usersPlans->with('plan')->where('user_id', auth()->id())->findOrFail($request->get('id'));
//
//        if($userplans->active && !$userplans->pause_flag){
//            $userplans->pause_flag = 1;
//            $userplans->pause_time =  Carbon::now()->addDays(config('settings.time_pause'));
//            $userplans->expired_time =  $userplans->expired_time->addDays(config('settings.time_pause'));
//        }else{
//            flash()->overlay('Upozorenje!', 'Paket je nije aktiviran.', 'info');
//             return redirect()->back();
//        }
//
//        $terms = $this->terms->whereBetween('start_datetime', [  Carbon::now() , Carbon::now()->addDays(config('settings.time_pause')) ] )->get();
//
//        $userTermsCount = $this->userTerms->where('user_delayed', 0)->whereIn('term_id', $terms->pluck('id'))->where('user_plan_id', $userplans->id)->count();
//
//        $userTerms = $this->userTerms->where('user_id', auth()->id())->where('user_delayed', 0)->where('user_plan_id', $userplans->id)->whereIn('term_id', $terms->pluck('id'))->with('term')->get();
//
//
//        foreach ($userTerms as $ut => $k){
//            $k->term->slots =  $k->term->slots +1;
//            $k->term->update();
//            $k->user_delayed = 1;
//            $k->update();
//        }
//
//        $userplans->terms_number = $userplans->terms_number + $userTermsCount;
//        $userplans->update();
//
//        flash()->overlay('Paket pauziran!', 'Paket je uspešno pauziran do: '.$userplans->pause_time->format('d.M.Y.') , 'success');
//
//        return redirect()->back();
//    }

    public function updatePauseOn(Request $request, $id){

        $userplans = $this->usersPlans->with('plan')->where('user_id', auth()->user()->id)->findOrFail($id);

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

        $userplans = $this->usersPlans->where('user_id', auth()->user()->id)->findOrFail($id);
        $userplans->pause_flag = 0;
        $userplans->pause_time =  Carbon::now();
        $userplans->expired_time = Carbon::now()->addDays( (int) $userplans->pause_from->diffInDays($userplans->expired_time, true) );
        $userplans->update();

        flash()->overlay(trans('flash.success'),trans('flash.userplans.spausedoff'));

        return redirect()->back();
    }


    public function getExtraPlan($planId)
    {

        $userplans = $this->usersPlans->with('plan')->findOrFail($planId);

        $user = User::findOrfail($userplans->user_id);

        $terms = $this->terms->where('start_datetime',  '<',  $userplans->pause_time->subDays(config('settings.time_pause')) )->get();
        $terms2 = $this->terms->where('start_datetime',  '>',  $userplans->pause_time )->get();

        $userTermsCount = $this->userTerms->where('user_delayed', 1)->whereIn('term_id', $terms->pluck('id'))->where('user_plan_id', $userplans->id)->count();
        $userTermsCount2 = $this->userTerms->where('user_delayed', 0)->whereIn('term_id', $terms->pluck('id'))->where('user_plan_id', $userplans->id)->count();
        $userTermsCount3 = $this->userTerms->where('user_delayed', 1)->whereIn('term_id', $terms2->pluck('id'))->where('user_plan_id', $userplans->id)->count();
        $userTermsCount4 = $this->userTerms->where('user_delayed', 0)->whereIn('term_id', $terms2->pluck('id'))->where('user_plan_id', $userplans->id)->count();

        return 'Vezbac:'.$user->name.' '.$user->lastname.' <br> Br. Plan:'.$userplans->id. ' / Pan od termina:'.$userplans->plan->workouts_number.'<br> Pre pauze: <br>Otkazao: '.$userTermsCount.'<br>Iskoristio: '.$userTermsCount2.'<br>  Posle pauze: <br>Otkazao: '.$userTermsCount3.' <br> Iskoristio:'. $userTermsCount4. '<br><br><br> Ostalo: '. $userplans->terms_number;

    }
}
