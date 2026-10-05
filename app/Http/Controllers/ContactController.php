<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Mail\ContactMail;
use Carbon\Carbon;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ContactController extends Controller
{
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

        $validator = Validator::make($request->all(), [
            'name' => 'required|max:50',
            'email' => 'required|email',
            'theme' => 'required|max:50',
            'question' => 'required|max:1500',
        ]);

        if (!$validator->fails()) {
            if ($this->getStoreTime()) {

                $emails = ['admin@imfit.rs'];

                Mail::to($emails)->send(new ContactMail($request->all()));

                // Only update the Session if an entry was inserted
                Session::put($host, Carbon::now()->addMinute()->timestamp);

                $contact = new Contact();
                $contact->fill($request->all());
                $contact->ip_adress = $request->getClientIp();
                $contact->save();

                flash()->overlay('Poslato!', 'Poruka je uspešno poslata. Odgovorićemo Vam u najkraćem mogućem roku.', 'success');

                return redirect()->back();
            }

             flash()->overlay('Upozorenje!', 'Prethodna poruka je već poslata, pokušajte ponovo kasnije. Hvala.', 'info');

            return redirect()->back()->withInput();
        }

         flash()->overlay('Greška!', implode('', $validator->errors()->all('<li>:message</li>')), 'error');

        return redirect()->back()->withInput()->withErrors($validator->errors());
    }
}
