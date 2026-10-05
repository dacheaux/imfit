<?php

namespace App\Http\Controllers;

use App\AccountPlan;
use App\AccountUserplan;
use App\Mail\NewPlanMail2;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;

class AccountUserPlansController extends Controller
{
    protected $accountPlan, $accountUserPlan;

    public function __construct(AccountPlan $accountPlan, AccountUserplan $accountUserPlan)
    {
        $this->accountPlan = $accountPlan;
        $this->accountUserPlan = $accountUserPlan;
        $this->middleware(['role:vežbač', 'auth']);
        parent::__construct();
    }

    public function index()
    {
        $accountUserPlan = $this->accountUserPlan->where('user_id', auth()->user()->id)->with('accountplan')->orderBy('created_at','desc')->paginate(8);

        return view('account.show', compact('accountUserPlan'));
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

        $accountPlan = $this->accountPlan->findOrFail($request->get('account_plan_id'));


        $validator = Validator::make($request->all(), [
            'account_plan_id' => 'required|exists:account_plans,id',
        ]);

        if (!$validator->fails()) {
            if ($this->getStoreTime()) {

                $emails = ['admin@imfit.rs'];

                Mail::to($emails)->send(new NewPlanMail2($accountPlan, auth()->user() ));

                // Only update the Session if an entry was inserted
                Session::put($host, Carbon::now()->addMinute()->timestamp);

                $userPlan = new AccountUserplan();
                $userPlan->account_plan_id = $request->get('account_plan_id');
                $userPlan->user_id = auth()->id();
                $userPlan->save();

                flash()->overlay('Poslato!', 'Plan je uspešno poručen.<br> Obavestićemo Vas kada plan bude odobren. <br> <span style=\"font-weight: 600;\">Molimo Vas da plan platite unapred. <br>Hvala.</span>', 'success');

                return redirect()->back();
            }

            flash()->overlay('Upozorenje!', 'Prethodna porudžbina je već poslata, pokušajte ponovo kasnije. Hvala.', 'info');

            return redirect()->back()->withInput();
        }

        flash()->overlay('Greška!', implode('', $validator->errors()->all('<li>:message</li>')), 'error');

        return redirect()->back()->withInput()->withErrors($validator->errors());
    }
}
