<?php

namespace App\Http\Controllers\Admin;

use App\Account;
use App\AccountPlan;
use App\AccountUserplan;
use App\Notifications\ApprovedPlanNotification2;
use App\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class AccountUserPlansController extends Controller
{

    protected $accountuserplans, $user, $accountplans, $account;

    public function __construct(AccountUserplan $accountuserplans , AccountPlan $accountplans, User $user, Account $account)
    {
        $this->accountuserplans = $accountuserplans;
        $this->accountplans = $accountplans;
        $this->user = $user;
        $this->account = $account;

        parent::__construct();
    }

    public function index()
    {
        $accountuserplans = $this->accountuserplans->all();

        return view('admin.accountuserplans.index', compact('accountuserplans'));
    }

    public function accountuserplansData(Request $request)
    {
        $accountuserplans = $this->accountuserplans->with('accountplan')->with('user')->latest();

        return DataTables::of($accountuserplans)
            ->addColumn('approved', function($accountuserplans) {
                return view('admin.accountuserplans.approved', compact('accountuserplans'))->render();
            })
            ->addColumn('paid', function($accountuserplans) {
                return view('admin.accountuserplans.paid', compact('accountuserplans'))->render();
            })
            ->addColumn('action1', function($accountuserplans) {
                return view('admin.accountuserplans.action1', compact('accountuserplans'))->render();
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['approved','paid','action1'])
            ->make(true);

    }

    public function create(AccountUserplan $accountuserplans)
    {
        $accountplans = $this->accountplans->get();

        $vezbaci = User::role('vežbač')->orderBy('created_at','desc')->get();

        return view('admin.accountuserplans.create', compact('accountplans', 'vezbaci', 'accountuserplans'));
    }

    public function store(Request $request)
    {
        $accountplans = $this->accountplans->find($request->get('account_plan_id'));

        $validator = Validator::make($request->all(), [
            'account_plan_id' => 'required|exists:account_plans,id',
            'user_id' => 'required|exists:users,id',
        ]);

        if (!$validator->fails()) {

            $accountuserplans = new AccountUserplan();
            $accountuserplans->user_id = $request->get('user_id');
            $accountuserplans->account_plan_id = $accountplans->id;
            $accountuserplans->save();

            flash()->overlay('Uspešno!', 'Plan je uspešno primenjen.', 'success');

            return redirect()->route('admin.accountuserplans.index');
        }

        flash()->overlay('Greška!', implode('', $validator->errors()->all('<li>:message</li>')), 'error');

        return redirect()->back()->withInput()->withErrors($validator->errors());
    }

    public function updateAccountPlan(Request $request, $id)
    {
        $accountuserplans = $this->accountuserplans->with('accountplan')->findOrFail($id);

        if($request->get('approved') ){
            $accountuserplans->approved = $request->get('approved') == 'true';
            $user = $this->user->findOrFail($accountuserplans->user_id);

            $account = $this->account->where('user_id', $user->id)->first();
            $account->balance =  $account->balance + $accountuserplans->accountplan->deposit_amount;
            $account->save();

            $user->notify( new ApprovedPlanNotification2($user) );

        }
        if($request->get('paid') ) {
            $accountuserplans->paid = $request->get('paid') == 'true';
        }

        $accountuserplans->save();

        return response()->json(['statut' => 'ok']);
    }

    public function destroy($id)
    {
        $this->accountuserplans->findOrfail($id)->delete();

        flash()->overlay(trans('flash.success'),trans('flash.accountuserplans.sdeleted'));

        return redirect(route('admin.accountuserplans.index'));
    }

}
