<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Spatie\Permission\Models\Role;

class RoleController extends Controller
{
    //
    protected $model;

    public function __construct(Role $model)
    {
        $this->model = $model;
    }

    public function index($number = 8)
    {
        $roles = $this->model->paginate($number);
        return view('dashboard.admin.role', ['roles' => $roles]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_cn' => 'required',
            'name' => ['required', 'unique:roles'],
            'guard' => 'required',
        ]);
        $role=$this->model->create([
            'name_cn' => $request->name_cn,
            'name' => $request->name,
            'guard_name' => $request->guard,
        ]);
        return back()->with('status', '成功添加了一个角色:' . $role->name);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_cn' => 'required',
            'name' => ['required', 'unique:roles,name,' . $id],
            'guard' => 'required',
        ]);
        $role = $this->model->find($id);
        $role->update([
            'name_cn' => $request->name_cn,
            'name' => $request->name,
            'guard_name' => $request->guard,
        ]);
        return back()->with('status', '成功更新了一个角色:' . $role->name);
    }

    public function info($id)
    {
        $role = $this->model->find($id);
        return response()->json($role);
    }

    public function rpinfo($id)
    {
        $role = $this->model->find($id);
        return response()->json($role->permissions->pluck('id'));
    }


    public function destroy($id)
    {
        $role = $this->model->findOrFail($id);
        $name = $role->name;
        $role->permissions()->detach();
        $role->delete();
        return back()->with('status', '成功删除了一个角色:' . $name);
    }
}
