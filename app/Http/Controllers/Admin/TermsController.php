<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTermsRequest;
use App\Plan;
use App\Term;
use App\Termpattern;
use App\User;
use App\UserTerm;
use App\Workout;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class TermsController extends Controller
{
    protected $terms, $workouts, $userTerms, $plan, $termpattern;

    public function __construct(Term $terms, Workout $workouts, UserTerm $userTerms, Plan $plan, Termpattern $termpattern)
    {
        $this->terms    = $terms;
        $this->userTerms    = $userTerms;
        $this->workouts     = $workouts;
        $this->termpattern = $termpattern;
        $this->plan   = $plan;

        parent::__construct();
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
//           $terms = $this->terms->with('workout')->with('coaches')->with(['userTerms' => function($q){
//               $q->where('delayed', 0);
//               $q->with('user');
//           }])->get();

        $workouts = $this->workouts->all();
        $coaches = User::role('trener')->get();

        return view('admin.terms.index', compact('workouts', 'coaches'));
    }

    public function dataTerms(Request $request)
    {
        if($request->ajax()) {

            $terms = Term::where(function($q) use ($request){

                    if( $request->get('end_datetime') != null){
                        $q->where('end_datetime', '>',  Carbon::now()->subDay($request->get('end_datetime')));
                    }else{
                        $q->where('end_datetime', '>', Carbon::now()->subDay(10));
                    }


                    if( $request->get('workout_id') != null){
                        $q->where('workout_id', '=', $request->get('workout_id'));
                    }
                    if ($request->get('coach_id') != null) {
                        $q->where('trener_id', '=', $request->get('coach_id'));
                    }
                })
                ->with(['workout', 'coaches','userTerms' => function($q){
                   $q->where('user_delayed', 0);
                   $q->with('user');
                }])->get();

            foreach ($terms as $index => $term) {
                $v = ' ';
                if( count($terms[$index]->userTerms) > 0 ) {
                    foreach ($terms[$index]->userTerms as $ut){
                        if($ut->user !== null){
                            $v .= $ut->user->name.' '.$ut->user->lastname. '; ';
                        }
                    }
                }
                $data[] = array(
                    'id' => $term->id,
                    'description' => $term->note,
                    'title' => $terms[$index]->workout->name.' - Trener: '.$terms[$index]->coaches[0]->name.' '.$terms[$index]->coaches[0]->lastname.' - Vežbači: '.$v,
                    'start' => $term->start_datetime->format('m/d/Y h:i a'),
                    'end' => $term->end_datetime->format('m/d/Y h:i a'),
                    'url' => url('admin/terms/'.$term->id)
                );
            }

            if(isset($data)){
                return response(json_encode($data));
            }else{
                return response( json_encode(['status' => false]) );
            }
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */

    public function create(Term $terms, UserTerm $userTerm)
    {
        $workouts = $this->workouts->get();

        $coaches = User::role('trener')->get();

        return view('admin.terms.form', compact('workouts', 'terms', 'userTerm', 'coaches'));
    }

    public function getTermPatterns()
    {
        $termpatterns = $this->termpattern->with('workout')->with('coach')->get();

        return view('admin.terms.patterns', compact('termpatterns'));
    }

    public function applyTermPatterns(Request $request)
    {
        $rules = array(
            'pattern_id'   => 'required|exists:termpatterns,id',
            'start_dates'  => 'required|array|min:1',
            'start_dates.*' => 'required|date',
        );
        $error = Validator::make($request->all(), $rules);

        if($error->fails())
        {
            return redirect()->back()->withErrors($error);
        }

        $termpattern = $this->termpattern->with('workout')->findOrFail($request->get('pattern_id'));
        $hours = unserialize($termpattern->hours);

        foreach ((array) $request->get('start_dates') as $dateStr) {
            $date = Carbon::parse($dateStr);
            foreach ($hours as $time) {
                $term = new Term();
                $term->workout_id = $termpattern->workout_id;
                $term->trener_id = $termpattern->trener_id;
                $term->slots = $termpattern->slots;
                $term->note = $termpattern->note;
                $term->start_datetime = $date->copy()->setTime($time->format('H'), $time->format('i'));
                $term->end_datetime = $date->copy()->setTime($time->format('H'), $time->format('i'))->addMinutes($termpattern->workout->workout_time);
                $term->save();
            }
        }

        flash()->overlay(trans('flash.success'), trans('flash.terms.screatedpat'));

        return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreTermsRequest $request)
    {
        $term = $this->terms->fill($request->only(['workout_id', 'trener_id', 'slots', 'note']));

        $workout = $this->workouts->findOrFail($request->get('workout_id'));

        $term->start_datetime = Carbon::parse($request->get('start_datetime'));
        $term->end_datetime = Carbon::parse($request->get('start_datetime'))->addMinutes($workout->workout_time);
        $term->save();


        flash()->overlay(trans('flash.success'),trans('flash.terms.screated'));

        return redirect(route('admin.terms.index'));

    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        $userTerm = $this->terms->where('id', $id)->with('userTerms.user')->firstOrFail();

        $coaches = User::role('trener')->get();

        $terms = $this->terms->findOrFail($id);
        $workouts = $this->workouts->get();
        //$userTerm = $this->userTerms->with('user')->get();


        return view('admin.terms.form', compact('workouts', 'terms', 'userTerm', 'coaches'));
    }



    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $term = $this->terms->findOrFail($id);
        if( $term->start_datetime < \Carbon\Carbon::now() ){

            flash()->overlay(trans('flash.info'),trans('Nije moguće ažuriranje, termin je završen ili je počeo.'), 'info');

            return redirect()->back();
        }
        $term->fill($request->only(['workout_id',  'trener_id','slots', 'note']));
        $userTerm = $this->userTerms->where('term_id', $term->id)->get();

//        if(! count($userTerm) > 0 ) {
//            $workout = $this->workouts->findOrFail($request->get('workout_id'));
//            $term->start_datetime = Carbon::parse($request->get('start_datetime'));
//            $term->end_datetime = Carbon::parse($request->get('start_datetime'))->addMinutes($workout->workout_time);
//        }

        $term->save();

        flash()->overlay(trans('flash.success'),trans('flash.terms.supdated'));

        return redirect()->back();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $this->terms->findOrFail($id)->delete();

        flash()->overlay(trans('flash.success'),trans('flash.terms.sdeleted'));
        return redirect(route('admin.terms.index'));
    }


    public function delayeduser(Request $request, $id)
    {

        $userTerms = $this->userTerms->where('user_id', $request->get('user_id'))->findOrFail($id);

        $userPlanId =  User::where('id', $request->get('user_id'))->with('userPlans')->firstOrFail();
        $term = $userTerms->term()->first();


        if( Carbon::parse($term->start_datetime) <= Carbon::now()->addHours(config('settings.time_delay')) ){
//              $term->slots = $term->slots + 1;
//            $term->save();
//            $userTerms->delete();

            flash()->overlay(trans('flash.error'),trans('Vežbač nije odložen, jer je proslo '.config('settings.time_delay') .' pre početka.'));

            return redirect()->back();
        }

        $plans = $this->plan->whereIn('id',  count($userPlanId->userPlans) > 0 ? $userPlanId->userPlans->pluck('plan_id') : 0)->where('workout_id', $term->workout_id)->with(['userPlans' => function($query) use($request) {
            $query->where('user_id', $request->get('user_id') )
                ->where('approved', 1)
                ->where('active', 1)
                ->where('expired_time', '>=', \Carbon\Carbon::now());
        }])->get();

        foreach ($plans as $plan){
            if(count($plan->userPlans)>0){
                foreach ($plan->userPlans as $p){
                    if($p->id == $userTerms->user_plan_id){
                        $p->terms_number = $p->terms_number + 1;
                        $p->save();
                    }
                }
            }
        }

        $term->slots = $term->slots + 1;
        $term->save();
        $userTerms->delete();

        flash()->overlay(trans('flash.success'),trans('Vežbač je odložen i vraćen mu termin.'));

        return redirect()->back();
    }
}
