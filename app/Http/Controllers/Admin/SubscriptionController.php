<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Shop;
use App\Services\BadrSubscriptionService;
use Carbon\Carbon;
use Illuminate\Http\Request;

class SubscriptionController extends Controller
{
    protected $model;
    protected $viewsDomain = 'dashboard.subscriptions.';

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
        $query = $this->model->subscriptions();

        // Filter by shop name or phone or code
        if ($request->filled('name')) {
            $term = $request->name;
            $query->where(function ($q) use ($term) {
                $q->where('shop_name', 'LIKE', '%' . $term . '%')
                  ->orWhere('shop_code', 'LIKE', '%' . $term . '%')
                  ->orWhere('phone', 'LIKE', '%' . $term . '%');
            });
        }

        // Filter by start date
        if ($request->filled('start_date')) {
            $query->whereDate('start_date', '>=', $request->start_date);
        }

        // Filter by end date
        if ($request->filled('end_date')) {
            $query->whereDate('end_date', '<=', $request->end_date);
        }

        // Filter by status (active/inactive)
        if ($request->filled('active') && $request->active !== 'all') {
            $query->where('active', $request->active);
        }

        // Filter by shop type (جملة / تجزئة)
        if ($request->filled('shop_type') && $request->shop_type !== 'all') {
            $query->where('shop_type', $request->shop_type);
        }

        $records = $query->orderBy('sort_order', 'asc')
                         ->latest('id')
                         ->paginate($request->input('per_page', 15))
                         ->appends($request->all());

        return $this->view('index', compact('records'));
    }

    public function create()
    {
        $record = $this->model;
        $record->active = 1;
        $record->start_date = Carbon::today()->format('Y-m-d');
        $record->end_date = Carbon::today()->addMonth()->format('Y-m-d');
        $record->shop_type = 'تجزئة';
        $record->sort_order = 0;

        return $this->view('create', compact('record'));
    }

    public function store(Request $request)
    {
        $rules = [
            'shop_name' => 'required|string|max:100',
            'shop_code' => 'required|numeric|unique:shops,shop_code',
            'phone' => 'nullable|string|max:50',
            'address' => 'required|string|max:255',
            'link_api' => 'required|string|max:255',
            'admin_link_api' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'shop_type' => 'required|string|in:جملة,تجزئة',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
        ];

        $messages = [
            'shop_name.required' => 'يرجى إدخال اسم المحل',
            'shop_code.required' => 'يرجى إدخال كود الدعم الفني',
            'shop_code.unique' => 'كود الدعم موجود بالفعل',
            'address.required' => 'يرجى إدخال عنوان المحل',
            'link_api.required' => 'يرجى إدخال رابط API الخاص بالتطبيق',
            'start_date.required' => 'يرجى تحديد تاريخ بداية الاشتراك',
            'end_date.required' => 'يرجى تحديد تاريخ نهاية الاشتراك',
            'end_date.after_or_equal' => 'تاريخ نهاية الاشتراك يجب أن يكون مساوياً أو بعد تاريخ البداية',
            'shop_type.required' => 'يرجى اختيار نوع النشاط (جملة أو تجزئة)',
            'image.required' => 'يرجى إرفاق صورة المحل',
            'image.image' => 'الملف المرفق يجب أن يكون صورة صالحة',
        ];

        $this->validate($request, $rules, $messages);

        $data = $request->except(['image', '_token']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs(
                'shops/' . date('Y-m'),
                $request->image->hashName(),
                'public'
            );
            $data['image'] = $imagePath;
        }

        $data['subscription'] = 1;
        $data['sort_order'] = $request->input('sort_order', 0) ?? 0;

        // Auto disable for app if end_date is in past or inactive
        $isLive = ($data['active'] == 1 && Carbon::parse($data['end_date'])->endOfDay()->isFuture()) ? 1 : 0;
        $data['is_live'] = $isLive;

        $shop = Shop::create($data);

        // Sync with merchant control panel (badrshop46)
        // If inactive, send null to set run_date = NULL in badr_shop
        $syncNotice = '';
        if (!empty($shop->admin_link_api)) {
            $syncEndDate = ($shop->active == 1) ? Carbon::parse($shop->end_date)->format('Y-m-d') : null;
            $syncRes = BadrSubscriptionService::syncSubscription(
                $shop->admin_link_api,
                $shop->shop_code,
                $syncEndDate
            );

            if (!empty($syncRes['status'])) {
                $syncNotice = ' (تمت مزامنة حالة الاشتراك مع لوحة التاجر)';
            } else {
                $syncNotice = ' (تنبيه: تعذر المزامنة مع لوحة التاجر: ' . ($syncRes['message'] ?? 'فشل الاتصال') . ')';
            }
        }

        session()->flash('success', 'تم إضافة الاشتراك بنجاح' . $syncNotice);
        return redirect(route('subscriptions.index'));
    }

    public function edit($id)
    {
        $record = Shop::subscriptions()->findOrFail($id);
        return $this->view('edit', compact('record'));
    }

    public function update(Request $request, $id)
    {
        $record = Shop::subscriptions()->findOrFail($id);

        $rules = [
            'shop_name' => 'required|string|max:100',
            'shop_code' => 'required|numeric|unique:shops,shop_code,' . $id,
            'phone' => 'nullable|string|max:50',
            'address' => 'required|string|max:255',
            'link_api' => 'required|string|max:255',
            'admin_link_api' => 'nullable|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'required|date|after_or_equal:start_date',
            'shop_type' => 'required|string|in:جملة,تجزئة',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'active' => 'required|in:0,1',
            'sort_order' => 'nullable|integer',
        ];

        $messages = [
            'shop_name.required' => 'يرجى إدخال اسم المحل',
            'shop_code.required' => 'يرجى إدخال كود الدعم الفني',
            'shop_code.unique' => 'كود الدعم موجود بالفعل',
            'address.required' => 'يرجى إدخال عنوان المحل',
            'link_api.required' => 'يرجى إدخال رابط API الخاص بالتطبيق',
            'start_date.required' => 'يرجى تحديد تاريخ بداية الاشتراك',
            'end_date.required' => 'يرجى تحديد تاريخ نهاية الاشتراك',
            'end_date.after_or_equal' => 'تاريخ نهاية الاشتراك يجب أن يكون مساوياً أو بعد تاريخ البداية',
            'shop_type.required' => 'يرجى اختيار نوع النشاط (جملة أو تجزئة)',
        ];

        $this->validate($request, $rules, $messages);

        $data = $request->except(['image', '_token', '_method']);

        if ($request->hasFile('image')) {
            $imagePath = $request->file('image')->storeAs(
                'shops/' . date('Y-m'),
                $request->image->hashName(),
                'public'
            );
            $data['image'] = $imagePath;
        }

        $data['subscription'] = 1;
        $data['sort_order'] = $request->input('sort_order', 0) ?? 0;

        // Auto disable for app if end_date is in past or inactive
        $isLive = ($data['active'] == 1 && Carbon::parse($data['end_date'])->endOfDay()->isFuture()) ? 1 : 0;
        $data['is_live'] = $isLive;

        $record->update($data);

        // Sync with merchant control panel (badrshop46)
        // If inactive, send null to set run_date = NULL in badr_shop
        $syncNotice = '';
        if (!empty($record->admin_link_api)) {
            $syncEndDate = ($record->active == 1) ? Carbon::parse($record->end_date)->format('Y-m-d') : null;
            $syncRes = BadrSubscriptionService::syncSubscription(
                $record->admin_link_api,
                $record->shop_code,
                $syncEndDate
            );

            if (!empty($syncRes['status'])) {
                $syncNotice = ($record->active == 1)
                    ? ' (تم مزامنة تاريخ الانتهاء بنجاح مع لوحة التاجر)'
                    : ' (تم تعطيل الاشتراك وتصفير تاريخ التاجر إلى NULL بنجاح)';
            } else {
                $syncNotice = ' (تنبيه: تعذر المزامنة مع لوحة التاجر: ' . ($syncRes['message'] ?? 'فشل الاتصال') . ')';
            }
        }

        return redirect(route('subscriptions.index'))
            ->with('success', 'تم تحديث بيانات الاشتراك بنجاح' . $syncNotice);
    }

    public function destroy($id)
    {
        $record = Shop::subscriptions()->findOrFail($id);

        // When deleting, sync with merchant panel by setting run_date to NULL
        if (!empty($record->admin_link_api)) {
            BadrSubscriptionService::syncSubscription(
                $record->admin_link_api,
                $record->shop_code,
                null
            );
        }

        $record->delete();

        return redirect(route('subscriptions.index'))
            ->with('success', 'تم حذف الاشتراك بنجاح');
    }

    /**
     * Manual sync action for a specific subscription
     */
    public function syncNow($id)
    {
        $record = Shop::subscriptions()->findOrFail($id);

        if (empty($record->admin_link_api)) {
            return redirect()->back()->with('error', 'رابط API لوحة التحكم غير مسجل لهذا المحل.');
        }

        $syncEndDate = ($record->active == 1) ? Carbon::parse($record->end_date)->format('Y-m-d') : null;
        $res = BadrSubscriptionService::syncSubscription(
            $record->admin_link_api,
            $record->shop_code,
            $syncEndDate
        );

        if (!empty($res['status'])) {
            return redirect()->back()->with('success', 'تمت المزامنة بنجاح مع لوحة التاجر: ' . ($res['message'] ?? ''));
        }

        return redirect()->back()->with('error', 'فشلت المزامنة: ' . ($res['message'] ?? 'تعذر الاتصال'));
    }
}
