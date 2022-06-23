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

    public function index($number = 2)
    {
        $permissions = $this->model->paginate($number);
        return view('dashboard.admin.permission', ['permissions' => $permissions]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'name_cn' => 'required',
            'name' => 'required',
            'guard' => 'required',
        ]);
        $this->model->create([
            'name_cn' => $request->name_cn,
            'name' => $request->name,
            'guard_name' => $request->guard,
        ]);
        return back();
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'name_cn' => 'required',
            'name' => 'required',
            'guard' => 'required',
        ]);
        $permission = $this->model->find($id);
        $permission->update([
            'name_cn' => $request->name_cn,
            'name' => $request->name,
            'guard_name' => $request->guard,
        ]);
        return back();
    }
    public function info($id)
    {
        $permission = $this->model->find($id);
        return response()->json($permission);
    }
}
