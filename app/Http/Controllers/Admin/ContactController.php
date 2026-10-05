<?php

namespace App\Http\Controllers\Admin;

use App\Contact;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class ContactController extends Controller
{
    protected $contacts;

    public function __construct(Contact $contacts)
    {
        $this->contacts = $contacts;

        parent::__construct();
    }

    public function index()
    {
        return view('admin.contacts.index');
    }

    public function contactsData()
    {
        $contacts = $this->contacts->get();

        return DataTables::of($contacts)
            ->addColumn('action', function($contacts) {
                return view('admin.contacts.action', compact('contacts'))->render();
            })
            ->addColumn('action1', function($contacts) {
                return view('admin.contacts.action1', compact('contacts'))->render();
            })
            ->editColumn('id', 'ID: {{$id}}')
            ->rawColumns(['action', 'action1'])
            ->make(true);
    }

    public function update(Request $request, $id)
	{

        $contacts = $this->contacts->findOrFail($id);
        $contacts->seen = $request->get('seen') == 'true';
        $contacts->save();

        return response()->json(['statut' => 'ok']);
	}


    public function destroy($id)
    {
        $contacts = $this->contacts->findOrFail($id);

        $contacts->delete();

        flash()->overlay(trans('flash.success'),trans('flash.contacts.sdeleted'));

        return redirect(route('admin.contacts.index'));
    }

}
