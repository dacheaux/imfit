<?php

namespace App\Http\Controllers\Aptreneri;

use App\Contact;
use App\Http\Controllers\Controller;
use App\Post;
use App\User;
use App\UserPlan;
use Illuminate\Http\Request;


class AdminController extends Controller
{
    protected $qcode;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(\App\Qrcode $qcode)
    {
        $this->qcode = $qcode;
        parent::__construct();
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $qcode = $this->qcode->where('user_id', auth()->id())->firstOrfail();

        $token = $qcode->token;

        return view('aptreneri.dashboard.index', compact('token'));
    }

      /**
     * Show the application login form for admin area.
     *
     * @return \Illuminate\Http\Response
     */
    public function login()
    {
        return view('aptreneri.login');
    }


}
