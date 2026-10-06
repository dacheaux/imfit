<?php

namespace App\Http\Controllers\Admin;


use App\Entry;
use App\User;
use App\Http\Controllers\Controller;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;
use Yajra\DataTables\DataTables;

class EntryController extends Controller
{
    protected $entry, $users;

    public function __construct(Entry $entry, User $users)
    {
        $this->entry = $entry;
        $this->users = $users;
        parent::__construct();
    }

    public function index()
    {
        $users = $this->users->get();

        $notSeenEntry = $this->entry->where('seen', 0)->get();

        foreach ($notSeenEntry as $entry){
            $entry->seen = 1;
            $entry->save();
        }

        return view('admin.entrances.index', compact('users'));
    }


    public function entryData(Request $request)
    {
        list($from, $to) = Entry::parseFilterRange($request->input('from'), $request->input('to'));

        $entrances = $this->entry
            ->where(function($q) use ($request){
                if( $request->get('user_id') != null){
                    $q->where('user_id', '=', $request->get('user_id'));
                }
            })
            ->whereBetween('entry_time', [$from, $to])
            ->with('user')->orderBy('id','desc')->get();


        $data = new Collection();

        foreach ($entrances as $index => $v){
            if( $entrances[$index]->user !== null){
                $data->push([
                    'id'   => $v->id,
                    'entry_time'       => $v->entry_time->format('d.M.Y H:i:s'),
                    'username'       => $entrances[$index]->user->name .' '. $entrances[$index]->user->lastname,
                    'type'       => $v->type == 0 ? 'vežbač' : 'trener',
                    'seen'       => $v->seen,
                    'payment_status' => $v->payment_status,
                    'plan_status' => $v->plan_status,
                    'message' => $v->message,
                ]);
            }
        }

        return DataTables::of($data)
            ->editColumn('id', '{{$id}}')
            ->addColumn('payment_status', function($data){
                return view('admin.entrances.paymentstatus', compact('data'));
            })
            ->addColumn('plan_status', function($data){
                return view('admin.entrances.planstatus', compact('data'));
            })
            ->addColumn('seen', function($data){
                return view('admin.entrances.seen', compact('data'));
            })
            ->addColumn('action', function($data){
                return view('admin.entrances.action', compact('data'));
            })
            ->rawColumns(['payment_status', 'plan_status','seen','action'])
            ->make(true);
    }

    public function destroy($id)
    {
        $entry = $this->entry->findOrFail($id);

        $entry->delete();

        flash()->overlay(trans('flash.success'),trans('flash.entrances.sdeleted'));

        return redirect(route('admin.entrances.index'));
    }

}
