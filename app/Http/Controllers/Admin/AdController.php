<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Ad;
use Illuminate\Http\Request;

class AdController extends Controller
{
    protected $model;
    protected $viewsDomain = 'dashboard.ads.';

    public function __construct(Ad $model)
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
            if ($request->title) {
                $query->where('title', 'LIKE', '%' . $request->title . '%');
            }
            if ($request->filled('active') && $request->active !== 'all') {
                $query->where('active', $request->active);
            }
        })->orderBy('order', 'asc')->latest('id')->paginate($request->input('per_page', 15));

        return $this->view('index', compact('records'));
    }

    public function create()
    {
        $record = $this->model;
        $record->active = 1;
        $record->order = 0;
        return $this->view('create', compact('record'));
    }

    public function store(Request $request)
    {
        $rules = [
            'title' => 'required|string|max:255',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'order' => 'nullable|numeric',
            'active' => 'required|in:0,1',
            'link' => 'nullable|url|max:3072',
        ];

        $messages = [
            'title.required' => 'يرجى إدخال عنوان الإعلان',
            'image.required' => 'يرجى إرفاق صورة الإعلان',
            'image.image' => 'الملف المرفق يجب أن يكون صورة صالحة',
            'link.url' => 'صيغة رابط الإعلان غير صالحة',
        ];

        $this->validate($request, $rules, $messages);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs(
                'ads/' . date('Y-m'),
                $request->image->hashName(),
                'public'
            );
            $data['image'] = $imagePath;
        }

        $data['order'] = $request->input('order', 0) ?? 0;
        $this->model->create($data);

        session()->flash('success', 'تم إضافة الإعلان بنجاح');
        return redirect(route('ads.index'));
    }

    public function edit($id)
    {
        $record = $this->model->findOrFail($id);
        return $this->view('edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = $this->model->findOrFail($id);

        $rules = [
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg,webp|max:3072',
            'order' => 'nullable|numeric',
            'active' => 'required|in:0,1',
            'link' => 'nullable|url|max:3072',
        ];

        $messages = [
            'title.required' => 'يرجى إدخال عنوان الإعلان',
            'image.image' => 'الملف المرفق يجب أن يكون صورة صالحة',
            'link.url' => 'صيغة رابط الإعلان غير صالحة',
        ];

        $this->validate($request, $rules, $messages);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs(
                'ads/' . date('Y-m'),
                $request->image->hashName(),
                'public'
            );
            $data['image'] = $imagePath;
        }

        $data['order'] = $request->input('order', 0) ?? 0;
        $record->update($data);

        return redirect(route('ads.index'))->with('success', 'تم تحديث الإعلان بنجاح');
    }

    public function destroy($id)
    {
        $record = $this->model->findOrFail($id);
        $record->delete();

        return redirect(route('ads.index'))->with('success', 'تم حذف الإعلان بنجاح');
    }
}

