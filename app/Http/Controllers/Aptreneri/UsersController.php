<?php

namespace App\Http\Controllers\Aptreneri;


use App\Account;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\UpdateUserRequest;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;
use Intervention\Image\ImageManagerStatic as Image;
use phpDocumentor\Reflection\DocBlock\Tag;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Spatie\Permission\Models\Role;
use Yajra\DataTables\Facades\DataTables;
use App\Http\Requests;

class UsersController extends Controller
{
    protected $users, $qcode, $account;

    public function __construct(User $users,  \App\Qrcode $qcode, Account $account)
    {
        $this->users = $users;
        $this->qcode = $qcode;
        $this->account = $account;

        parent::__construct();
    }

    public function index()
    {
        if(auth()->user()->id !== 13){
            abort(404);
        }
        return view('aptreneri.users.index');
    }

    public function usersData()
    {
         //$users = $this->users->get();

        return DataTables::of(User::query())
            ->addColumn('qrcode', function($users) {
                return view('aptreneri.users.qrcode', compact('users'))->render();
            })
            ->addColumn('action', function($users) {
                return view('aptreneri.users.action', compact('users'))->render();
            })
            ->addColumn('action1', function($users) {
                return view('aptreneri.users.action1', compact('users'))->render();
            })
            ->rawColumns(['qrcode','action', 'action1'])
            ->make(true);
    }

    public function profile(User $user)
    {
        return view('aptreneri.users.profile', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {

        $user = User::findOrFail($id);

        if ($user->hasRole('admin')){
            return redirect()->back()->withErrors(['message' => 'Ne možete da izmenite admina.']);
        }

        if($request->hasFile('avatar')){

            $this->uploadAvatar($request->file('avatar'), $user);

            $user->fill($request->only('type', 'name', 'lastname', 'phone', 'note'));
            $user->birth = $request->input('birth');
            $user->save();
            if(\auth()->user()->id != $id){
                $this->syncUserRole( $request['roles'], $user);
            }

        }else{
            $user->fill($request->only('type','name', 'lastname', 'phone', 'note'));
            $user->birth = $request->input('birth');
            $user->save();
            if(\auth()->user()->id != $id){
                $this->syncUserRole( $request['roles'], $user);
            }
        }

        flash()->success(trans('flash.success'),trans('flash.users.supdated'));

        return redirect(route('aptreneri.users.index') );
    }

    public function create(User $user)
    {
        if(auth()->user()->id !== 13){
            abort(404);
        }

        $roles = Role::where('name' ,'vežbač')->get();//Get all roles

        return view('aptreneri.users.form', compact('user', 'roles'));
    }

    public function store(Requests\StoreUserRequest $request)
    {


        $gpasswod = Str::random(8);
        $user = $this->users;



          if($request->hasFile('avatar')){

            $this->uploadAvatar($request->file('avatar'), $user);
            $user->fill($request->only('type','name', 'lastname', 'phone', 'note', 'email'));
            $user->birth = $request->input('birth');
            $user->password = bcrypt($gpasswod);
            $user->save();

            $this->assignUserRole($request['roles'], $user);

          }else{

          $user->fill($request->only('type','name', 'lastname', 'phone', 'note','email', 'password'));
          $user->birth =  $request->input('birth');
          $user->password = bcrypt($gpasswod);
          $user->save();
          $this->assignUserRole($request['roles'], $user);

        }

        if($user){
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

            $this->account->create([
                'user_id' => $user->id,
                'balance' => 0,
            ]);
        }


        $notify = User::sendWelcomeEmail($user, $gpasswod);

        if($notify){
            flash()->overlay(trans('flash.success'),trans('flash.users.screated'));

            return redirect(route('aptreneri.users.index'));
        }

        return redirect(route('aptreneri.users.index'));

    }

    public function edit($id)
    {
        if(auth()->user()->id !== 13){
            abort(404);
        }

        $roles = Role::all();//Get all roles
        $user = $this->users->with('qrcode')->findOrFail($id);


        if ($user->hasRole('admin') || $user->hasRole('trener') && \auth()->user()->id !== $user->id ){
            return redirect()->back()->withErrors(['message' => 'Ne možete da izmenite admina/trenera.']);
        }

        return view('aptreneri.users.form', compact('user', 'roles'));
    }


    public function destroy(Requests\DeleteUserRequest $request, $id)
    {
        if(auth()->user()->id !== 13){
            abort(404);
        }

        $user = $this->users->findOrFail($id);

        if ($user->hasRole('admin') || $user->hasRole('trener')){
            return redirect()->back()->withErrors(['message' => 'Ne možete da obrišete admina/trenera.']);
        }

        $user->delete();

        flash()->overlay(trans('flash.success'),trans('flash.users.sdeleted'));

        return redirect(route('aptreneri.users.index'));
    }


    /**
     * @param $roles
     * @param $user
     */
    protected function assignUserRole($roles, $user)
    {
        if (isset($roles)) {
            //foreach ($roles as $role) {
                $role_r = Role::where('id', '=', $roles)->firstOrFail();
                $user->assignRole($role_r); //Assigning role to user
            //}
        }
    }

    /**
     * @param $roles
     * @param $user
     */
    protected function syncUserRole($roles, $user)
    {
        if (isset($roles)) {
                $user->roles()->sync($roles);  //If one or more role is selected associate user to roles
        } else {
            $user->roles()->detach(); //If no role is selected remove exisiting role associated to a user
        }
    }

    /**
     * @param Requests\StoreUserRequest $request
     * @param $user
     */
    protected function uploadAvatar($avatar, $user)
    {
        $filename = time() . '.' . $avatar->getClientOriginalExtension();
        Image::make($avatar)->fit(300, 300)->save(public_path('/uploads/avatars/' . $filename));
        if (\File::exists(public_path() . $user->avatar)) {
            \File::delete(public_path() . $user->avatar);
        }
        $user->avatar = '/uploads/avatars/' . $filename;
    }
}
