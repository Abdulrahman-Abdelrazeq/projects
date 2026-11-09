<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;

class BadrSubscriptionService
{
    /**
     * Synchronize subscription end date and online status with merchant panel (badrshop)
     *
     * @param string|null $adminLinkApi
     * @param string $shopCode
     * @param string|null $endDate YYYY-MM-DD or null if inactive
     * @param int $online Always 1 for subscriptions in badrshop
     * @return array
     */
    public static function syncSubscription($adminLinkApi, $shopCode, $endDate)
    {
        if (empty($adminLinkApi)) {
            return [
                'status' => false,
                'message' => 'رابط API لوحة التحكم غير محدد لهذا المحل.'
            ];
        }

        $url = rtrim($adminLinkApi, '/') . '/api/update_subscription.php';
        $secretKey = config('services.badr.secret_key', env('BADR_API_SECRET_KEY', 'badr_secret_key_2026_auth'));

        // If inactive or null date passed, explicitly send 'null' to set run_date = NULL in badr_shop
        $runDateVal = (empty($endDate) || $endDate === 'null') ? 'null' : $endDate;

        $payload = [
            'api_key'   => $secretKey,
            'shop_code' => $shopCode,
            'run_date'  => $runDateVal,
        ];

        try {
            // Send both as form data and with X-Api-Key header to ensure compatibility
            $response = Http::timeout(10)
                ->asForm()
                ->withHeaders([
                    'X-Api-Key' => $secretKey,
                    'Accept'    => 'application/json',
                ])
                ->post($url, $payload);

            if ($response->successful()) {
                return $response->json() ?? [
                    'status' => true,
                    'message' => 'تم التحديث بنجاح في لوحة التاجر'
                ];
            }

            $json = $response->json();
            $msg = $json['message'] ?? ('فشل التحديث في لوحة التاجر - رمز الاستجابة: ' . $response->status());
            Log::warning("Badr sync warning for shop [{$shopCode}] at [{$url}]: {$msg}");

            return [
                'status' => false,
                'message' => $msg
            ];
        } catch (\Exception $e) {
            Log::error("Badr sync exception for shop [{$shopCode}] at [{$url}]: " . $e->getMessage());
            return [
                'status' => false,
                'message' => 'تعذر الاتصال بلوحة التاجر: ' . $e->getMessage()
            ];
        }
    }
}
