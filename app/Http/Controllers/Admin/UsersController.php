<?php

namespace App\Http\Controllers\Admin;


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
        return view('admin.users.index');
    }

    public function usersData()
    {
         //$users = $this->users->get();

        return DataTables::of(User::query())
            ->addColumn('qrcode', function($users) {
                return view('admin.users.qrcode', compact('users'))->render();
            })
            ->addColumn('action', function($users) {
                return view('admin.users.action', compact('users'))->render();
            })
            ->addColumn('action1', function($users) {
                return view('admin.users.action1', compact('users'))->render();
            })
            ->rawColumns(['qrcode','action', 'action1'])
            ->make(true);
    }

    public function profile(User $user)
    {
        return view('admin.users.profile', compact('user'));
    }

    public function update(UpdateUserRequest $request, $id)
    {

        $user = User::findOrFail($id);

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

        return redirect(route('admin.users.index') );
    }

    public function create(User $user)
    {
        $roles = Role::all();//Get all roles

        return view('admin.users.form', compact('user', 'roles'));
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
            $this->createQrCodeFor($user);

            $this->account->create([
                'user_id' => $user->id,
                'balance' => 0,
            ]);
        }


        $notify = User::sendWelcomeEmail($user, $gpasswod);

        if($notify){
            flash()->overlay(trans('flash.success'),trans('flash.users.screated'));

            return redirect(route('admin.users.index'));
        }

        return redirect(route('admin.users.index'));

    }

    public function edit($id)
    {
        $roles = Role::all();//Get all roles
        $user = $this->users->with('qrcode')->findOrFail($id);

        return view('admin.users.form', compact('user', 'roles'));
    }

    public function storeQrcode($id)
    {
        $user = $this->users->with('qrcode')->findOrFail($id);

        if ($user->qrcode) {
            flash()->overlay(trans('flash.info'), trans('flash.users.qrexists'));

            return redirect()->route('admin.users.edit', $user->id);
        }

        $this->createQrCodeFor($user);

        flash()->overlay(trans('flash.success'), trans('flash.users.sqrcreated'));

        return redirect()->route('admin.users.edit', $user->id);
    }


    public function destroy(Requests\DeleteUserRequest $request, $id)
    {
        $user = $this->users->findOrFail($id);

        $user->delete();

        flash()->overlay(trans('flash.success'),trans('flash.users.sdeleted'));

        return redirect(route('admin.users.index'));
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
     * @param User $user
     */
    protected function createQrCodeFor(User $user)
    {
        $token = bcrypt(auth()->id() . time());
        $fileImage = 'qrcode'.$user->id.'.png';
        $path = public_path('images/'.$fileImage);
        QrCode::size(500)->format('png')->generate($token, $path);

        $this->qcode->create([
            'user_id' => $user->id,
            'token' => $token,
            'qrcode_image' => $fileImage,
            'type' => $user->hasRole('vežbač') ? 0 : 1
        ]);
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
