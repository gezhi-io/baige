<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Permission;
use Spatie\Permission\Models\Role;

class PermissionController extends Controller
{
    //
    protected $model;
    protected $administrator;

    public function __construct(Permission $model)
    {
        $this->model = $model;
        $this->administrator = Role::where('name', 'administrator')->first();
    }

    public function index(Request $request)
    {
        if ($request->has('number')) {
            $number = intval($request->number);
            
        } else {
            $number = 10;
        }
        $permissions = $this->model->paginate($number);
        $root = $this->model->where('name', 'manage-everything')->first();
        $tops = $this->model->where('parent_id', $root->id)->get();
        return view('dashboard.admin.permission', ['permissions' => $permissions, 'root' => $root, 'tops' => $tops, 'number' => $number]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_cn' => 'required',
            'name' => ['required', 'unique:permissions'],
            'parent_id' => 'required',
            'guard' => 'required',
        ]);
        $permission = $this->model->create([
            'name_cn' => $request->name_cn,
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'guard_name' => $request->guard,
        ]);
        $this->administrator->givePermissionTo($permission);
        return back()->with('status', '成功添加了一个权限:' . $permission->name);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_cn' => 'required',
            'name' => ['required', 'unique:permissions,name,' . $id],
            'parent_id' => 'required',
            'guard' => 'required',
        ]);
        $permission = $this->model->find($id);
        $permission->update([
            'name_cn' => $request->name_cn,
            'name' => $request->name,
            'parent_id' => $request->parent_id,
            'guard_name' => $request->guard,
        ]);
        return back()->with('status', '成功更新了一个权限:' . $permission->name);
    }
    public function info($id)
    {
        $permission = $this->model->find($id);
        return response()->json($permission);
    }

    public function destroy($id)
    {
        $permission = $this->model->findOrFail($id);
        $name = $permission->name;
        $permission->roles()->detach();
        $permission->delete();
        return back()->with('status', '成功删除了一个权限:' . $name);
    }
}
