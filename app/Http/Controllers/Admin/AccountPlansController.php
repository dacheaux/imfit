<?php

namespace App\Http\Controllers\Admin;

use App\Http\Requests\StoreAccountPlanRequest;
use App\AccountPlan;
use App\Http\Requests\UpdateAccountPlanRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Yajra\DataTables\Facades\DataTables;

class AccountPlansController extends Controller
{
    protected $accountplans;

    public function __construct(AccountPlan $accountplans)
    {
        $this->accountplans = $accountplans;

        parent::__construct();
    }

    public function index()
    {
        return view('admin.accountplans.index');
    }

    public function accountplansData()
    {
        $accountplans = $this->accountplans->get();

        return DataTables::of($accountplans)
            ->addColumn('action0', function($accountplans) {
                return view('admin.accountplans.action0', compact('accountplans'))->render();
            })
            ->addColumn('action1', function($accountplans) {
                return view('admin.accountplans.action1', compact('accountplans'))->render();
            })
            ->addColumn('action2', function($accountplans) {
                return view('admin.accountplans.action2', compact('accountplans'))->render();
            })
            ->editColumn('id', '{{$id}}')
            ->rawColumns(['action0','action1','action2'])
            ->make(true);

    }


    public function create(AccountPlan $accountplans)
    {
        return view('admin.accountplans.form', compact('accountplans'));
    }


    public function store(StoreAccountPlanRequest $request)
    {
        $this->accountplans->fill($request->only('plan_name','deposit_amount'))->save();

        flash()->overlay(trans('flash.success'),trans('flash.plans.screated'));

        return redirect(route('admin.accountplans.index'));
    }


    public function edit($id)
    {
        $accountplans = $this->accountplans->findOrfail($id);

        return view('admin.accountplans.form', compact('accountplans'));
    }

    public function update(UpdateAccountPlanRequest $request, $id)
    {
        $accountplans = $this->accountplans->findOrfail($id);

        $accountplans->fill($request->only('plan_name','deposit_amount'))->save();

        flash()->overlay(trans('flash.success'),trans('flash.plans.supdated'));

        return redirect(route('admin.accountplans.index'));
    }

    public function updateActive(Request $request, $id)
    {

        if($request->ajax()){
            $accountplans = $this->accountplans->findOrFail($id);
            $accountplans->inactive = $request->get('inactive') == 'true';
            $accountplans->save();

            return response()->json(['statut' => 'ok']);
        }

    }


    public function destroy($id)
    {
        $this->accountplans->findOrfail($id)->delete();

        flash()->overlay(trans('flash.success'),trans('flash.plans.sdeleted'));

        return redirect(route('admin.accountplans.index'));
    }

}
