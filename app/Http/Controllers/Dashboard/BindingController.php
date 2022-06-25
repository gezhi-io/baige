<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Spatie\Permission\Models\Role;

class BindingController extends Controller
{
    //
    protected $roleModel;
    protected $permissionModel;

    public function __construct(Permission $permissionModel, Role $roleModel)
    {
        $this->roleModel = $roleModel;
        $this->permissionModel = $permissionModel;
    }
    public function assign()
    {
        $roles = $this->roleModel->where('name','<>','administrator')->get();
        $permissions = $this->permissionModel->where('parent_id',1)->get();
        $root = $this->permissionModel->where('name', 'manage-everything')->first();
        return view('dashboard.admin.binding', ['roles' => $roles, 'permissions' => $permissions,'root'=>$root]);
    }

    public function sync(Request $request){
            $role=$this->roleModel->findOrFail($request->role);
            $permissions=$request->permissions;
            $role->syncPermissions($permissions);
            return back()->with('status','成功修改授权');

    }
}
