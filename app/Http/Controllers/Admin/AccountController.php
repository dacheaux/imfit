<?php

namespace App\Http\Controllers\Admin;

use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\Facades\DataTables;

class AccountController extends Controller
{
    protected $account;

    public function __construct(Account $account)
    {
        $this->account = $account;

        parent::__construct();
    }

    public function index()
    {
        return view('admin.accounts.index');
    }

    public function accountsData()
    {
        $accounts = $this->account->with('user')->get();

        return DataTables::of($accounts)
            ->addColumn('action0', function($accounts) {
                return view('admin.accounts.action0', compact('accounts'))->render();
            })
            ->rawColumns(['action0'])
            ->make(true);

    }

    public function edit($id)
    {
        $account = $this->account->findOrfail($id);

        return view('admin.accounts.form', compact('account'));
    }

    public function update(Request $request, $id)
    {
        $account = $this->account->findOrfail($id);

        $validator = Validator::make($request->all(), [
            'balance' => 'required|numeric'
        ]);

        if (!$validator->fails()) {

            $account->fill($request->only('balance'))->save();

            flash()->overlay(trans('flash.success'),trans('flash.accounts.supdated'));

            return redirect(route('admin.accounts.index'));
        }

        flash()->overlay('Greška!', implode('', $validator->errors()->all('<li>:message</li>')), 'error');

        return redirect()->back()->withInput()->withErrors($validator->errors());
    }

}
