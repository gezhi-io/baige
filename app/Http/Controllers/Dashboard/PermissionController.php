<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Permission;

class PermissionController extends Controller
{
    //
    protected $model;

    public function __construct(Permission $model)
    {
        $this->model = $model;
    }

    public function index($number = 8)
    {
        $permissions = $this->model->paginate($number);
        return view('dashboard.admin.permission', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_cn' => 'required',
            'name' => ['required', 'unique:permissions'],
            'guard' => 'required',
        ]);
        $permission=$this->model->create([
            'name_cn' => $request->name_cn,
            'name' => $request->name,
            'guard_name' => $request->guard,
        ]);
        return back()->with('status', '成功添加了一个权限:' . $permission->name);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_cn' => 'required',
            'name' => ['required', 'unique:permissions,name,' . $id],
            'guard' => 'required',
        ]);
        $permission = $this->model->find($id);
        $permission->update([
            'name_cn' => $request->name_cn,
            'name' => $request->name,
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
