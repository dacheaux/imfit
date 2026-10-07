<?php

namespace App\Http\Controllers;

use App\GlobalConf;
use App\Plan;
use App\Term;
use App\User;
use App\UserPlan;
use App\UserTerm;
use App\Workout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class TermsController extends Controller
{
    protected $terms, $workouts, $userTerms, $users, $membership, $plan, $userPlans, $userPlan;

    public function __construct(Term $terms, Workout $workouts, UserTerm $userTerms, User $users, Plan $plan, UserPlan $userPlan)
    {
        $this->terms = $terms;
        $this->userTerms = $userTerms;
        $this->workouts = $workouts;
        $this->users = $users;
        $this->plan = $plan;
        $this->userPlan = $userPlan;
        $this->middleware(['role:vežbač', 'auth']);
        parent::__construct();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //return config('settings.time_book');
        //$user = $this->users->where('id', auth()->id())->with('membership')->firstOrFail();
        //dd(Carbon::parse($user->toArray()['membership']['expired_time']) < \Carbon\Carbon::now());
       // $terms = $this->terms->where('id', 10)->with('userTerms.user.membership')->firstOrFail();

        //dd(  $terms->userTerms[0]->delayed  );
        //dd(  $terms->userTerms[0]->user->toArray()['membership']['id']  );


//            $plan = $this->plan->where('workout_id', 2)->with(['userPlans' => function($query) {
//                $query->where('user_id', \auth()->id())
//                    ->where('approved', 1)
//                    ->where('active', 1)
//                    ->where('expired_time', '>=', \Carbon\Carbon::now())
//                    ->where('terms_number', '>', 0);
//            }])->firstOrFail();
//
//            dd($plan->toArray());

//            $userPlans = $this->userPlans->where('user_id', auth()->id())->with(['plan' => function ($query) {
//            $query->where('workout_id', 1);
//        }])->get();

//        $terms = $this->terms->with(['workout' => function($q) {
//            $q->whereId(1);
//        }])->where('start_datetime', '<', Carbon::now()->addDays(0))->get();
//
//        return $terms[0]->workout->name;

        $userPlans = $this->userPlan->with('plan')->where('user_id', auth()->id())->get();
        $coaches = User::role('trener')->get();

        $data=[];
        foreach ($userPlans as $wid){
            if (!in_array($wid->plan->workout_id, $data)){
                $data[] = $wid->plan->workout_id;
            }
        }

        $workouts = $this->workouts->whereIn('id',$data)->get();

        return view('pages.termini',  compact('workouts', 'coaches'));
    }

    public function dataTerms(Request $request)
    {
        if ($request->ajax()) {

            $userType = \auth()->user()->type == 0 ? 30 : 7;

            $terms = $this->terms->with(['workout' => function($q) use ($request){
                if( $request->get('workout_id') != null){
                    $q->where('id', '=', $request->get('workout_id'));
                }
            }])->with('coaches')->where('start_datetime', '<', Carbon::now()->addDays($userType))
                ->where('end_datetime', '>', Carbon::now()->subMonth(1))
                ->where(function($q) use ($request) {
                    if ($request->get('coach_id') != null) {
                        $q->where('trener_id', '=', $request->get('coach_id'));
                    }
                })
                ->get();

            foreach ($terms as $index => $term) {

                if(!$term->slots  > 0 || $term->start_datetime <= Carbon::now()->addHours(config('settings.time_book'))){
                    $color = "4";
                    $desc = "<br>Nije moguće zakazivanje za izabran termin.<br><div id='msg'></div>";
                    }else{
                    $color = "1";
                    $start = $term->start_datetime->format('d.m.Y. H:i');
                    $desc = "<br><h3>Preostalo mesta: <b style='color: #bfd630;'>" . $term->slots . "</b></h3><br><p>Trener: <b>" .$terms[$index]->coaches[0]->name." ".$terms[$index]->coaches[0]->lastname."</b></p> <p>Početak treninga: <b>$start</b> </p><br><br>" . $term->note . " <br><br> <div class=\"text-center\"><button class=\"ff_button\" onclick=\"bookTermin($(this))\" data-id=\"$term->id\">Zakaži termin.</button><br><div id='msg'></div></div></div>";
                }

                if($terms[$index]->workout != null) {
                    $data[] = array(

                        "name" => $terms[$index]->workout->name,
                        "coach" => $terms[$index]->coaches[0]->name ." ".$terms[$index]->coaches[0]->lastname,
                        "date" => $term->start_datetime->format('d'),
                        "month" => $term->start_datetime->format('m'),
                        "year" => $term->start_datetime->format('Y'),
                        "day" => $term->start_datetime->format('D'),
                        "start_time" => $term->start_datetime->format('H:i'),
                        "end_time" => $term->end_datetime->format('H:i'),
                        "color" => $color,
                        "description" => $desc

                    );
                }
            }
            if(isset($data)){
                return response(json_encode($data));
            }else{
                return response( json_encode(['status' => false]) );
            }


        }
    }

    public function bookingTerms(Request $request)
    {

        if ($request->ajax()) {

            $data = array(
                'login' => false,           // da li je ulogovan  T
                'deadline' => false,            // da li je proslo X sati pre pocetka termina F
                'slots' => false,            // da li ima slobodnih mesta T
                'has_booked' => false,       // da li je vec bookirao taj termin F
                'delayed' => false,             // da li je otkazao taj termin  F
                'plan' => false,                // da li ima plan T
            );

            if (Auth::check()) {
                $data['login'] = true;

                $terms = $this->terms->where('id', $request->get('id'))->with('userTerms.user')->firstOrFail();

                $user = $this->users->where('id', auth()->id())->with(['userPlans' => function ($query) {
                    $query->where('terms_number', '>', 0)
                            ->where('expired_time', '>=', Carbon::now());
                }])->firstOrFail();

                if(count($user->userPlans) > 0) {

                    try {
                        $plan = $this->plan->whereIn('id', count($user->userPlans) > 0 ? $user->userPlans->pluck('plan_id') : 0)->where('workout_id', $terms->workout_id)->with(['userPlans' => function ($query) use($terms) {
                            $query->where('user_id', \auth()->id())
                                ->where('approved', 1)
                                ->where('active', 1)
                                ->where('expired_time', '>=', Carbon::parse($terms->start_datetime))
                                ->where('terms_number', '>', 0)
                                ->where('pause_flag', 0);
                        }])->firstOrFail();
                    }
                    catch (\Exception $e) { // I don't remember what exception it is specifically
                        $data['booked'] = false;
                        return response()->json($data);
                    }


                }else{
                     $data['booked'] = false;
                    return response()->json($data);
                }

//                $userPlans = $this->userPlans->where('user_id', auth()->id())->where('approved', 1)
//                    ->with(['plan' => function ($query) use($terms) {
//                    $query->where('workout_id', $terms->workout_id);
//                }])->get();


                if ( Carbon::parse($terms->start_datetime) <= Carbon::now()->addHours(config('settings.time_book')) ) {
                    $data['deadline'] = true;
                }
                if ($terms->slots > 0) {
                    $data['slots'] = true;
                }

                //dd($terms->userTerms->toArray());

                if (count($terms->userTerms)) {
                    foreach ($terms->userTerms as $term){

                        if ($term->term_id == $request->get('id') && $term->user_id == $user->id && $term->user_delayed == 0) {
                            $data['has_booked'] = true;
                        }
                        if ($term->term_id == $request->get('id') && $term->user_id == $user->id && $term->user_delayed == 1) {
                            $data['delayed'] = true;
                        }
                    }
                }

                if(count($plan->userPlans) > 0){
                    $data['plan'] = true;
                    $userPlans = $plan->userPlans[0];
                }

            }
            if (
                $data['login'] == true &&
                $data['deadline'] == false &&
                $data['slots'] == true &&
                $data['has_booked'] == false &&
                $data['delayed'] == false &&
                $data['plan'] == true
            ) {

                $data['booked'] = true;
                $userTerms = $this->userTerms->fill(['user_id' => $user->id, 'term_id' => $terms->id, 'user_plan_id' => $userPlans->id]);

                $terms->slots = ($terms->slots -1);
                $userPlans->terms_number = ($userPlans->terms_number - 1);

                $terms->save();
                $userPlans->save();
                $userTerms->save();

            } else {
                $data['booked'] = false;
            }


            return response()->json($data);
        }

    }
}
