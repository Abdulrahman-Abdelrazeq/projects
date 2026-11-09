<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Resources\ListShopResource;
use App\Models\Ad;
use App\Models\Instruction;
use App\Models\Shop;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Artisan;

class ShopController extends Controller
{
    public function list()
    {
        if (request()->ip() == '197.43.117.211') {
            request()->headers->set('env-type', 'test');
        }

        $v = 5;
        if (request('v') >= $v) {
            $v = request('v');
        }

        \Log::info(request('v'));

        $today = Carbon::today()->format('Y-m-d');

        if (request()->header('env-type') == 'test') {
            $query = Shop::where('is_live', 0);
        } else {
            $query = Shop::where('active', 1)
                ->where('is_live', 1)
                ->where(function ($q) use ($today) {
                    // Non-subscription shops OR subscription shops whose end_date is today or in future
                    $q->where(function ($subQ) {
                        $subQ->where('subscription', 0)->orWhereNull('subscription');
                    })->orWhere(function ($subQ) use ($today) {
                        $subQ->where('subscription', 1)
                             ->where(function ($dateQ) use ($today) {
                                 $dateQ->whereNull('end_date')
                                       ->orWhereDate('end_date', '>=', $today);
                             });
                    });
                });
        }

        if (request('name') && strlen(request('name'))) {
            $query->where('shop_name', 'LIKE', '%' . request('name') . '%');
        }

        // Order by sort_order ascending, then by id ascending
        $query->orderBy('sort_order', 'asc')->orderBy('id', 'asc');

        $records = $query->paginate(request('per_page', 15));

        foreach ($records as $record) {
            $link = $record->link_api;
            $link = str_replace('/api/v4', '/api/v' . $v, $link);
            $record->link_api = $link;
        }

        $last_page = $records->lastPage();
        $current_page = request('page') ?? 1;
        $source = ListShopResource::collection($records);

        $auto_start = false;

        $data = [
            'data' => $source,
            'current_page' => $current_page,
            'last_page' => $last_page,
            'auto_start' => $auto_start
        ];

        if (count($records) > 0) {
            return response()->json([
                'status' => true,
                'data' => $data
            ]);
        } else {
            $response = [
                "msg" => "لا يوجد محلات ",
                "status" => false
            ];
            return response()->json($response, 200);
        }
    }

    public function instructions()
    {
        $data = Instruction::select('id', 'order', 'notes', 'image')->orderBy('order')->get();

        if ($data->isEmpty()) {
            return response()->json([
                'status' => false,
                "msg" => "لا يوجد تعليمات ",
            ]);
        }
        return response()->json([
            'status' => true,
            'data' => $data,
        ]);
    }

    public function ads()
    {
        $ads = Ad::active()->orderBy('order', 'asc')->latest('id')->get()->map(function ($ad) {
            return [
                'id' => $ad->id,
                'title' => $ad->title,
                'image' => asset('storage/' . $ad->image),
                'link' => $ad->link,
                'order' => $ad->order,
                'active' => $ad->active,
            ];
        });

        if ($ads->isEmpty()) {
            return response()->json([
                'status' => false,
                'msg' => 'لا يوجد إعلانات حالياً',
                'data' => []
            ], 200);
        }

        return response()->json([
            'status' => true,
            'data' => $ads
        ], 200);
    }

    /**
     * API request to execute CheckExpiredSubscriptions command
     */
    public function checkExpiredSubscriptions(Request $request)
    {
        $expectedSecret = env('BADR_API_SECRET_KEY', 'badr_secret_key_2026_auth');
        $providedSecret = $request->header('X-Api-Key') ?? $request->input('api_key');

        if ($providedSecret !== $expectedSecret && !in_array($request->ip(), ['127.0.0.1', '::1'])) {
            return response()->json([
                'status' => false,
                'message' => 'غير مصرح بالوصول: مفتاح الأمان السري غير صحيح أو مفقود.'
            ], 401);
        }

        try {
            Artisan::call('subscriptions:check-expired');
            $output = Artisan::output();

            return response()->json([
                'status' => true,
                'message' => 'تم فحص وتعطيل الاشتراكات المنتهية بنجاح.',
                'output' => trim($output)
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'status' => false,
                'message' => 'حدث خطأ أثناء تنفيذ الفحص: ' . $e->getMessage()
            ], 500);
        }
    }
}
