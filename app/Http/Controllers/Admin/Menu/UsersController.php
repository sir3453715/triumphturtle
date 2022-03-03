<?php

namespace App\Http\Controllers\Admin\Menu;

use App\Http\Controllers\Controller;
use App\Models\ActionLog;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;
use Spatie\Permission\Models\Role;

class UsersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $type_array = ['administrator','manager','customer'];
        $queried = array();
        if(Auth::user()->hasRole('administrator')){
            $roles = Role::orderBy('id','ASC')
                ->get();
        }else{
            $roles = Role::where('name','!=','administrator')
                ->orderBy('id','ASC')->get();
//            $type_array = ['manager','customer'];
            $type_array = ['manager'];
        }
        if($request->get('type') != 0) {
            $role = Role::find($request->get('type'));
            if($role){
                $type_array = [$role->name];
                $queried['type'] = $request->get('type');
            }
        }
        $users = User::role($type_array);

        if($request->get('email')) {
            $users = $users->where('email', $request->get('email'));
            $queried['email'] = $request->get('email');
        }

        $users = $users->paginate(20);
        return view('admin.user.user',[
            'users'=>$users,
            'roles' => $roles,
            'queried' => $queried,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        if(Auth::user()->hasRole('administrator')){
            $roles = Role::orderBy('id','ASC')
                ->get();
        }else{
//            $roles = Role::where('name','!=','administrator')
            $roles = Role::where('name','=','manager')
                ->orderBy('id','ASC')->get();
        }
        return view('admin.user.createUser',[
            'roles' => $roles,
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->toArray(),[
            'name'=>'required',
            'password'=>'required|min:8',
            're_password' => 'required|min:8|same:password',
            'email'=>'required|email|unique:users',
        ]);
        if($validator->fails()){
            $message = '<ul>';
            foreach ($validator->errors()->all() as $text){
                $message .= '<li>'.$text.'</li>';
            }
            $message .= '</ul>';
            return back()->withInput()->with('error',$message);
        }else{
            $data=[
                'name'=>$request->get('name'),
                'email'=>$request->get('email'),
                'password'=>Hash::make($request->get('password')),
                "email_notification" => ($request->get('email_notification'))??0,
            ];
            $user = User::create($data);
            ActionLog::create_log($user,'create');

            if($request->get('users_role')){
                $role = Role::find($request->get('users_role'));
                if(!$user) {
                    $user->assignRole($role->name);
                }else{
                    $user->syncRoles($role->name);
                }
            }


            return redirect(route('admin.user.index'))->with('message', '帳號已建立!');
        }
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $user = User::find($id);
        if(Auth::user()->hasRole('administrator')) {
            $roles = Role::orderBy('id','ASC')
                ->get();
        }else{
//            $roles = Role::where('name','!=','administrator')
            $roles = Role::where('name','=','manager')
                ->orderBy('id','ASC')
                ->get();
        }
        return view('admin.user.editUser',[
            'user'=>$user,
            'roles' => $roles,
            'user_roles' => $user->roles()->first()->id,
        ]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $user = User::find($id);

        $data=[
            'name'=>$request->get('name'),
            "email_notification" => ($request->get('email_notification'))??0,
        ];
        if($request->get('change_password')=='1'){
            if($request->get('password')){
                $data['password'] = Hash::make($request->get('password'));
            }
        }
        $user->fill($data);
        ActionLog::create_log($user);
        $user->save();

        if($request->get('users_role')){
            $role = Role::find($request->get('users_role'));
            if(!$user) {
                $user->assignRole($role->name);
            }else{
                $user->syncRoles($role->name);
            }
        }

        return redirect(route('admin.user.index'))->with('message', '資料已更新!');

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
        $user = User::find($id);
        if($user){
            $user->delete();
            ActionLog::create_log($user,'delete');
        }

        return redirect(route('admin.user.index'))->with('message', '資料已刪除!');

    }
}
