<?php

namespace App\Http\Controllers;

use App\Contact;
use App\Entry;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Support\Facades\Auth;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        $this->middleware(function ($request, $next) {

            view()->share('guest', Auth::guest());
            view()->share('logedUser', Auth::user());
            //view()->share('contactsCount', Contact::whereSeen(false)->latest()->count());

            return $next($request);
        });
    }
}
