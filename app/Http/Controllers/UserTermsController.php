<?php

namespace App\Http\Controllers;


use App\Plan;
use App\Term;
use App\User;
use App\UserTerm;
use App\Workout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

class UserTermsController extends Controller
{

    protected $terms, $workouts, $userTerms, $membership, $plan;

    public function __construct(Term $terms, Workout $workouts, UserTerm $userTerms, Plan $plan)
    {
        $this->terms    = $terms;
        $this->userTerms    = $userTerms;
        $this->workouts     = $workouts;
        $this->plan     = $plan;
        $this->middleware(['role:vežbač', 'auth']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $userTerms = $this->userTerms->where('user_id', auth()->id())->where('user_delayed', 0)->with('term.workout')->orderBy('created_at', 'desc')->paginate(10);
        $userTerms2 = $this->userTerms->where('user_id', auth()->id())->where('user_delayed', 1)->with('term.workout')->orderBy('created_at', 'desc')->paginate(10);

        //$member = $this->membership->where('user_id',auth()->id())->firstOrFail();

        //return $userTerms[0]->user->toArray()[0]->membership->id;

        return view('pages.mojitermini', compact('userTerms', 'userTerms2'));
    }



    public function delayedTerm(Request $request)
    {

        if ($request->ajax()) {
            if (\auth()->user()->id == $request->get('user_id')) {
                //$userTerms = $this->userTerms->where('user_id', $id)->findOrFail($request->get('user_terms_id'));
                $userTerms = DB::table('user_terms')->where('id', $request->get('user_terms_id'))->where('user_id', $request->get('user_id'))->first();

                $userPlanId = User::where('id', $request->get('user_id'))->with('userPlans')->firstOrFail();
                $term = $this->terms->where('id', $userTerms->term_id)->firstOrFail();


                if (Carbon::parse($term->start_datetime) <= Carbon::now()->addHours(config('settings.time_delay'))) {

//                $userTerms->delayed = 1;
//                $term->save();
//                $userTerms->save();

//                    flash()->overlay(trans('flash.error'),
//                        trans('Termin nije otkazan ' . config('settings.time_delay') . ' sati pre početka, zbog toga termin se računa kao iskorišćen.'));

                    return response(json_encode(['status' => false]));
                }

                $plans = $this->plan->whereIn('id', count($userPlanId->userPlans) > 0 ? $userPlanId->userPlans->pluck('plan_id') : 0)->where('workout_id', $term->workout_id)->with(['userPlans' => function ($query) use ($userTerms) {
                    $query->where('user_id', \auth()->user()->id)
                        ->where('approved', 1)
                        ->where('active', 1)
                        ->where('expired_time', '>=', \Carbon\Carbon::now());
                }])->get();


                foreach ($plans as $plan) {
                    if (count($plan->userPlans) > 0) {
                        foreach ($plan->userPlans as $p) {
                            if ($p->id == $userTerms->user_plan_id) {
                                $p->terms_number = $p->terms_number + 1;
                                $p->save();
                            }
                        }
                    }
                }

                DB::table('user_terms')->where('id', $request->get('user_terms_id'))->where('user_id', $request->get('user_id'))->update(
                    ['user_delayed' => 1]
                );

                $term->slots = $term->slots + 1;
                $term->save();

                return response(json_encode(['status' => true]));
            }

            return response(json_encode(['status' => false]));
        }

        return response(json_encode(['status' => false]));

    }

}
