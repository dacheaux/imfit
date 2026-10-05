<?php

namespace App\Http\Controllers\Aptreneri;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreTermsRequest;
use App\Plan;
use App\Term;
use App\User;
use App\UserTerm;
use App\Workout;
use Carbon\Carbon;
use Illuminate\Http\Request;

class TermsController extends Controller
{
    protected $terms, $workouts, $userTerms, $plan;

    public function __construct(Term $terms, Workout $workouts, UserTerm $userTerms, Plan $plan)
    {
        $this->terms    = $terms;
        $this->userTerms    = $userTerms;
        $this->workouts     = $workouts;
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
        $workouts = $this->workouts->all();
        $coaches = User::role('trener')->get();

        return view('aptreneri.terms.index', compact('workouts', 'coaches'));
    }

    public function dataTerms(Request $request)
    {
        if($request->ajax()) {

            $terms = $this->terms
                ->where(function($q) use ($request){

                    $q->where('end_datetime', '>', Carbon::now()->subDay(10));

                    if( $request->get('workout_id') != null){
                        $q->where('workout_id', '=', $request->get('workout_id'));
                    }
                    if ($request->get('coach_id') != null) {
                        $q->where('trener_id', '=', $request->get('coach_id'));
                    }
                })
                ->with('workout')->with('coaches')->with(['userTerms' => function($q){
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
                    'url' => url('aptreneri/terms/'.$term->id)
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

        return view('aptreneri.terms.form', compact('workouts', 'terms', 'userTerm', 'coaches'));
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

        return redirect(route('aptreneri.terms.index'));

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


        return view('aptreneri.terms.form', compact('workouts', 'terms', 'userTerm', 'coaches'));
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
        $workout = $this->workouts->findOrFail($request->get('workout_id'));
        $term->start_datetime = Carbon::parse($request->get('start_datetime'));
        $term->end_datetime = Carbon::parse($request->get('start_datetime'))->addMinutes($workout->workout_time);
        $term->save();


        flash()->overlay(trans('flash.success'),trans('flash.terms.supdated'));

        return redirect(route('aptreneri.terms.index'));
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
        return redirect(route('aptreneri.terms.index'));
    }


    public function delayeduser($id)
    {
        $userTerms = $this->userTerms->findOrFail($id);

        $user  = $userTerms->with('user')->first();
        $term = $userTerms->term()->first();
        if( Carbon::parse($term->start_datetime) <= Carbon::now()->addHours(config('settings.time_delay')) ){

            $userTerms->delete();

            flash()->overlay(trans('flash.success'),trans('Vežbač je odložen, ali mu nije vraćen termin.'));

            return redirect()->back();
        }
        $term->slots = $term->slots + 1;
        $plan = $this->plan->where('workout_id', $term->workout_id)->with(['userPlans' => function($query) use($userTerms) {
            $query->where('user_id', $userTerms->user->id)
                ->where('approved', 1)
                ->where('active', 1);
        }])->first();

        if (count($plan->userPlans) > 0) {
            foreach ($plan->userPlans as $plan){
                if($plan->id == $userTerms->user_plan_id){
                    $plan->terms_number =   $plan->terms_number + 1;
                    $plan->save();
                }
            }
        }

        $term->save();
        $userTerms->delete();

        flash()->overlay(trans('flash.success'),trans('Vežbač je odložen i vraćen mu termin.'));

        return redirect()->back();
    }
}
