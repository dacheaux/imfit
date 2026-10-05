<?php

namespace App\Http\Controllers;

use App\AccountPlan;
use App\User;
use App\Plan;
use Illuminate\Http\Request;

class AccountController extends Controller
{
    protected $user, $account, $accountplans;

    public function __construct(User $user, \App\Account $account, AccountPlan $accountplans)
    {
        $this->middleware('auth');
        $this->user = $user;
        $this->account = $account;
        $this->accountplans = $accountplans;
    }

    public function index()
    {
        $account = $this->account->where('user_id', auth()->user()->id)->first();
        $accountplans = $this->accountplans->whereInactive(1)->get();

        return view('account.index', compact('accountplans', 'account'));
    }

    public function generateAccount()
    {
        $users =  $this->user->all();

        foreach ($users as $user)
        {
            $this->account->create([
                'user_id' => $user->id,
            ]);

        }

        return 'OK.';
    }
}
