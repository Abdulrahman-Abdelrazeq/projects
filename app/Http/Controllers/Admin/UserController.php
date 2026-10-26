<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;

class UserController extends Controller
{
    protected $model;
    protected $viewsDomain = 'dashboard/users.';

    public function __construct()
    {
        $this->model = new User();
    }

    private function view($view, $params = [])
    {
        return view($this->viewsDomain . $view, $params);
    }

    public function index(Request $request)
    {
        $records = $this->model->where(function ($query) use ($request) {
            if ($request->name) {
                $query->where('id', $request->name);
            }
        })->paginate($request->input('per_page'));
        return $this->view('index', compact('records'));
    }

    public function create()
    {
        $record = $this->model;
        return $this->view('create', compact('record'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ];
        $messages = ([
            'name.required' => 'يرجي ادخال اسم العضو',
            'email.required' => 'يرجي ادخال البريد الالكتروني ',
            'email.unique' => 'البريد الالكتروني موجود بالفعل ',
            'password.required' => 'يرجي ادخال كلمه المرور ',
            'password.confirmed' => 'كلمتا المرور غير متطابقه',
        ]);
        $this->validate($request, $rules, $messages);
        $input = $request->all();
        $input['password'] = Hash::make($input['password']);
        $user = User::create($input);
        session()->flash('success', __('تم اضافه المستخدم بنجاح'));
        return redirect(route('users.index'));
    }

    public function edit($id)
    {
        $record = User::find($id);
        return $this->view('edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|unique:users,email,' . $id,
            'password' => 'nullable|confirmed',
        ];
        $messages = ([
            'name.required' => 'يرجي ادخال اسم العضو',
            'email.required' => 'يرجي ادخال البريد الالكتروني ',
            'email.unique' => 'البريد الالكتروني موجود بالفعل ',
            'password.confirmed' => 'كلمتا المرور غير متطابقه',
        ]);
        $this->validate($request, $rules, $messages);
        $record = User::find($id);
        $input = $request->except('password');
        if ($request->password) {
            $input['password'] = bcrypt($request->password);
        } else {
            $data = Arr::except($input, array('password'));
        }
        $record->update($input);
        return redirect(route('users.index'))
            ->with('success', 'تم تحديث معلومات المستخدم بنجاح');
    }

    public function changeStatus(Request $request)
    {
        $record = $this->model->findOrFail($request->id);
        if ($record->enabled == 1) {
            $record->update(['enabled' => 0]);
        } else {
            $record->update(['enabled' => 1]);
        }
        session()->flash('success', __('تم تعديل حاله المستخدم بنجاح'));
        return redirect(route('users.index'));
    }


}
