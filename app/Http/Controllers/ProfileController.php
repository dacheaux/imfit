<?php

namespace App\Http\Controllers;

use App\Http\Requests\UpdateProfileRequest;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Intervention\Image\Image;

class ProfileController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }


    public function index()
    {
        $user = Auth::user();
        return view('pages.profile', compact('user'));
    }


    public function update(UpdateProfileRequest $request, $id)
    {
        if (\auth()->user()->id == $id) {

            $user = User::findOrFail($id);

            if ($request->hasFile('avatar')) {

                $this->uploadAvatar($request->file('avatar'), $user);

                $user->fill($request->only('name', 'lastname', 'phone'));
                $user->password = bcrypt($request->input( 'password'));
                $user->birth = $request->input('birth');
                $user->save();
            }
            else {
            $user->fill($request->only('name', 'lastname', 'phone'));
            $user->password = bcrypt($request->input( 'password'));
            $user->birth = $request->input('birth');
            $user->save();
            }
        }else{
            abort(404);
        }

        flash()->success(trans('flash.success'),'Podaci su uspešno zapamćeni!');

        return redirect()->back();
    }


    protected function uploadAvatar($avatar, $user)
    {
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        \Image::make($avatar)->fit(300, 300)->save(public_path('/uploads/avatars/' . $filename));
        if (\File::exists(public_path() . $user->avatar)) {
            \File::delete(public_path() . $user->avatar);
        }
        $user->avatar = '/uploads/avatars/' . $filename;
    }
}
