<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Option;

class OptionController extends Controller
{
    //
    protected $model;

    public function __construct(Option $model)
    {
        $this->model = $model;
    }

    public function index($number = 10)
    {
        $options = $this->model->paginate($number);
        return view('dashboard.admin.option', ['options' => $options]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'value' => 'required',
            'name' => ['required', 'unique:options'],
            'excerpt' => 'required',
        ]);
        $option=$this->model->create([
            'value' => $request->value,
            'name' => $request->name,
            'excerpt' => $request->excerpt,
        ]);
        return back()->with('status', '成功添加了一个选项:' . $option->name);
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'value' => 'required',
            'name' => ['required', 'unique:options,name,' . $id],
            'excerpt' => 'required',
        ]);
        $option = $this->model->find($id);
        $option->update([
            'value' => $request->value,
            'name' => $request->name,
            'excerpt' => $request->excerpt,
        ]);
        return back()->with('status', '成功更新了一个选项:' . $option->name);
    }

    public function info($id)
    {
        $option = $this->model->find($id);
        return response()->json($option);
    }


    public function destroy($id)
    {
        $option = $this->model->findOrFail($id);
        $name = $option->name;
        $option->delete();
        return back()->with('status', '成功删除了一个选项:' . $name);
    }
}
