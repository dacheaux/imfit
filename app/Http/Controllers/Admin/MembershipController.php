<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreMembershipRequest;
use App\Http\Requests\UpdateMembershipRequest;
use App\Membership;
use App\User;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class MembershipController extends Controller
{
    protected $membership;

    public function __construct(Membership $membership)
    {
        $this->membership = $membership;
        parent::__construct();
    }

    public function index()
    {
       // return     $membership = $this->membership->with('user')->get();
        return view('admin.memberships.index');
    }

    public function membershipsData()
    {
        $membership = $this->membership->with('user')->get();

        return DataTables::of($membership)
            ->addColumn('action', function($membership) {
                return view('admin.memberships.user', compact('membership'))->render();
            })
            ->addColumn('action0', function($membership) {
                return view('admin.memberships.action0', compact('membership'))->render();
            })
            ->rawColumns(['id','user','action0'])
            ->make(true);
    }

    public function updateActive(Request $request, $id){
        if($request->ajax()){
            $membership = $this->membership->findOrFail($id);
            if($request->get('active')){
                $membership->active = $request->get('active') == 'true';
            }
            $membership->save();

            return response()->json(['statut' => 'ok']);
        }
    }


    public function create(Membership $membership)
    {

        $users = User::role('vežbač')->get();

        return view('admin.memberships.form', compact('membership', 'users'));
    }

    public function store(StoreMembershipRequest $request)
    {
        $this->membership->fill($request->only(['user_id', 'terms_number', 'expired_time']))->save();

        flash()->overlay(trans('flash.success'),trans('flash.memberships.screated'));

        return redirect(route('admin.memberships.index'));
    }


    public function update(UpdateMembershipRequest $request, $id)
    {
        $membership = $this->membership->findOrFail($id);
        $membership->fill($request->only(['user_id', 'terms_number', 'expired_time']));
        if(  \Carbon\Carbon::parse($membership->pause_time)->toDateTimeString() <= \Carbon\Carbon::now()->addDays(7) ){
            $membership->pause_flag = 0;
        }
        $membership->save();

        flash()->overlay(trans('flash.success'),trans('flash.memberships.supdated'));

        return view('admin.memberships.index');
    }


    public function edit($id)
    {
        $membership = $this->membership->with('user')->findOrFail($id);

        //$users = User::role('vežbač')->get();

        return view('admin.memberships.form', compact('membership'));
    }


    public function destroy($id)
    {
        //$this->membership->findOrFail($id)->delete();

        flash()->overlay(trans('flash.success'),trans('flash.memberships.sdeleted'));

        return redirect(route('admin.memberships.index'));
    }
}
