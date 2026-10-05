<?php

namespace App\Http\Controllers\Admin;

use App\AccountUserplan;
use App\Contact;
use App\Door;
use App\Entry;
use App\Http\Controllers\Controller;
use App\Plan;
use App\User;
use App\UserPlan;
use App\Charts\MontlyViews;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\DB;


class AdminController extends Controller
{

    protected $usersPlans, $users, $contacts, $orders, $posts, $doors, $accountuserplans;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(UserPlan $usersPlans, User $users, Contact $contacts, Entry $entrances, Door $doors,  \App\Qrcode $qcode, AccountUserplan $accountuserplans)
    {
        $this->usersPlans = $usersPlans;
        $this->users = $users;
        $this->contacts = $contacts;
        $this->accountuserplans = $accountuserplans;
        $this->qcode = $qcode;
        $this->entrances = $entrances;
        $this->doors = $doors;
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $nbrUsersPlans = $this->usersPlans->whereApproved(0)->count();
        $nbrUsers = $this->users->count();
        $nbrAccountUsersPlans = $this->accountuserplans->whereApproved(0)->count();

        $qcode = $this->qcode->where('user_id', auth()->id())->firstOrfail();

        $token = $qcode->token;

        $births = $this->users->all()->groupBy(function ($item, $key) {
            return Carbon::parse($item->birth)->day;
        });


        $birthData = [];

        for ($i=0; $i <= 31; $i++){
            if(isset($births[$i])){
                foreach ($births[$i] as $birth => $b){
                    if( Carbon::parse($b->birth)->month == Carbon::now()->month ){
                        $birthData[] = $b;
                    }
                }
            }
        }


        $userPlans = UserPlan::select('id', 'plan_id', 'created_at')
            ->whereBetween('created_at',array(Carbon::now()->startOfYear(), Carbon::now()->endOfYear()))
            ->where('paid', 1)
            ->with('plan')
            ->get()
            ->groupBy(function($date) {
                //return Carbon::parse($date->created_at)->format('Y'); // grouping by years
                return Carbon::parse($date->created_at)->format('M'); // grouping by months
            })
            ->map(function ($item) {

                $sum = 0;
                foreach($item as $i){
                    $sum  += $i->plan->price;
                }

                return $sum;
           });



        $chart = new MontlyViews;
        $chart->labels($userPlans->keys());
        $dataset = $chart->dataset('Uplata', 'line',  $userPlans->values());
        $dataset->color('#00c0ef');
        $dataset->fill('#0073b7');


        return view('admin.dashboard.index', compact('nbrUsersPlans','nbrUsers', 'chart', 'birthData', 'token', 'nbrAccountUsersPlans'));
    }

    public function openTheDoor(Request $request)
    {
        $door = $this->doors->findOrFail($request->get('door_id'));
        $door->fill(['door_state' => $request->get('door_state')]);
        $door->touch();
        $door->save();

        flash()->overlay('Upozorenje', 'Vrata će se uskoro otvoriti.');

        return redirect()->back();

    }

      /**
     * Show the application login form for admin area.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('admin.login');
    }


}
