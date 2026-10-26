<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Instruction;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class InstructionController extends Controller
{
    protected $model;
    protected $viewsDomain = 'dashboard/instructions.';

    public function __construct(Instruction $model)
    {
        $this->model = $model;
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
            'notes' => 'nullable',
            'order' => 'required|numeric',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $messages = ([
            'image.required' => 'يرجي ادخال صوره التعليمات ',
            'image.image' => 'يرجي ادخال صوره صحيحة  للتعليمات ',
            'order.required' => 'يرجي ادخال ترتيب التعليمات ',
        ]);
        $this->validate($request, $rules, $messages);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs(
                'instructions/' . date('Y-m'),
                $request->image->hashName(),
                'public'
            );
            $data['image'] = $imagePath;
        }
        $this->model->create($data);
        session()->flash('success', __('تم اضافه التعليمات بنجاح'));
        return redirect(route('instructions.index'));
    }

    public function edit($id)
    {
        $record = $this->model->find($id);
        return $this->view('edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = $this->model->find($id);;

        $rules = [
            'notes' => 'nullable',
            'order' => 'required|numeric',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
        $messages = ([
            'image.required' => 'يرجي ادخال صوره التعليمات ',
            'image.image' => 'يرجي ادخال صوره صحيحة  للتعليمات ',
            'order.required' => 'يرجي ادخال ترتيب التعليمات ',
        ]);

        $this->validate($request, $rules, $messages);
        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs(
                'instructions/' . date('Y-m'),
                $request->image->hashName(),
                'public'
            );
            $data['image'] = $imagePath;
        }
        $record->update($data);
        return redirect(route('instructions.index'))
            ->with('success', 'تم تحديث التعليمات بنجاح');
    }

    function destroy($id){
        $record = $this->model->findOrFail($id);
        $record->delete();
        return redirect(route('instructions.index'))
            ->with('success', 'تم الحذف التعليمات بنجاح');
    }


}
