<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Validation\Rules;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{
    //
    protected $model;
    protected $roleModel;

    public function __construct(User $model, Role $roleModel)
    {
        $this->model = $model;
        $this->roleModel = $roleModel;
    }

    public function index(Request $request)
    {
        if ($request->has('number')) {
            $number = intval($request->number);
            
        } else {
            $number = 10;
        }

        $users = $this->model->paginate($number);
        $roles=$this->roleModel->all();
        return view('dashboard.admin.user', ['users' => $users,'roles'=>$roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users'],
            'roles' => ['required'],
            'password' => ['required',  Rules\Password::defaults()],
        ]);
        $user = $this->model->create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);
        $roles=$request->roles;
        $user->syncRoles($roles);
        return back()->with('status', '成功添加了一个用户:' . $user->name);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:users,email,'.$id],
            'roles' => ['required'],
        ]);
        $user = $this->model->find($id);
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            
        ]);
        $roles=$request->roles;
        $user->syncRoles($roles);
        if($request->password){
            $user->update([ 'password' => Hash::make($request->password),]);
        }
        return back()->with('status', '成功更新了一个用户:' . $user->name);
    }
    public function info($id)
    {
        $user = $this->model->find($id);
        $user->roles=$user->roles()->pluck('name');
        return response()->json($user);
    }

    public function destroy($id)
    {
        $user = $this->model->findOrFail($id);
        $name = $user->name;
        if($user->hasRole('administrator')){
            return back()->with('status', '无法删除超级管理员');
        }else{
            $user->roles()->detach();
        $user->delete();
        return back()->with('status', '成功删除了一个用户:' . $name);
        }
        
    }
}
