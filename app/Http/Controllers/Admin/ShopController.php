<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use Illuminate\Http\Request;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Hash;
use Intervention\Image\Facades\Image;

class ShopController extends Controller
{
    protected $model;
    protected $viewsDomain = 'dashboard/shops.';

    public function __construct()
    {
        $this->model = new Shop();
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
            'shop_name' => 'required',
            'shop_code' => 'required|numeric|unique:shops,shop_code',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link_api' => 'required',
            'address' => 'required',
        ];
        $messages = ([
            'shop_name.required' => 'يرجي ادخال اسم المحل',
            'shop_code.required' => 'يرجي ادخال كود الدعم ',
            'shop_code.unique' => 'كود الدعم موجود بالفعل ',
            'image.required' => 'يرجي ادخال صوره المحل ',
            'address.required' => 'يرجي ادخال عنوان المحل ',
            'link_api.required' => 'يرجي ادخال رابط ال api ',
        ]);
        $this->validate($request, $rules, $messages);

        $data = $request->except('image');
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs(
                'shops/' . date('Y-m'),
                $request->image->hashName(),
                'public'
            );
            $data['image'] = $imagePath;
        }
        $shop = Shop::create($data);
        session()->flash('success', __('تم اضافه المحل بنجاح'));
        return redirect(route('shops.index'));
    }

    public function edit($id)
    {
        $record = Shop::find($id);
        return $this->view('edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = Shop::find($id);
        $rules = [
            'shop_name' => 'required',
            'shop_code' => 'required|numeric|unique:shops,shop_code,' . $id,
//            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link_api' => 'required',
            'address' => 'required',
        ];
        $messages = ([
            'shop_name.required' => 'يرجي ادخال اسم المحل',
            'shop_code.required' => 'يرجي ادخال كود الدعم ',
            'shop_code.unique' => 'كود الدعم موجود بالفعل ',
//            'image.required' => 'يرجي ادخال صوره المحل ',
            'address.required' => 'يرجي ادخال عنوان المحل ',
            'link_api.required' => 'يرجي ادخال رابط ال api ',
        ]);

        $this->validate($request, $rules, $messages);
        $data = $request->except('image');
        // dd($data);
        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs(
                'shops/' . date('Y-m'),
                $request->image->hashName(),
                'public'
            );
            $data['image'] = $imagePath;
        }
        $data['is_live'] = $data['active'] == 1 ? 1 : 0;
        $record->update($data);
        return redirect(route('shops.index'))
            ->with('success', 'تم تحديث المحل بنجاح');
    }


}