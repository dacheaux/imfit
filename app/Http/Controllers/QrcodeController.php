<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class QrcodeController extends Controller
{

    protected $user, $qcode;

    public function __construct(User $user, \App\Qrcode $qcode)
    {
        $this->middleware('auth');
        $this->user = $user;
        $this->qcode = $qcode;
    }


    public function index()
    {
        $qcode = $this->qcode->where('user_id', auth()->id())->firstOrfail();

        $token = $qcode->token;

        return view('pages.qrcode', compact('token'));
    }

    public function generateQrCode()
    {
       $users =  $this->user->all();

       foreach ($users as $user)
       {
           $token =  bcrypt(auth()->id() . time());
           $fileImage = 'qrcode'.$user->id.'.png';
           $path =  public_path('images/'.$fileImage);
           QrCode::size(500)->format('png')->generate($token,$path);

           $this->qcode->create([
               'user_id' => $user->id,
               'token' => $token,
               'qrcode_image' => $fileImage,
               'type' => $user->hasRole('vežbač') ? 0 : 1
           ]);

       }

       return 'OK.';
    }
}
