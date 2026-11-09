<?php

namespace App\Console\Commands;

use App\Models\Shop;
use App\Services\BadrSubscriptionService;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Log;

class CheckExpiredSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:check-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'تعطيل الاشتراكات المنتهية ومزامنة تاريخ التعطيل مع لوحة تحكم التاجر وتطبيق الموبايل';

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $today = Carbon::today()->format('Y-m-d');
        $this->info("بدء فحص الاشتراكات المنتهية لتاريخ اليوم: {$today}...");

        $expiredShops = Shop::subscriptions()
            ->whereNotNull('end_date')
            ->whereDate('end_date', '<', $today)
            ->where(function ($q) {
                $q->where('active', 1)->orWhere('is_live', 1);
            })
            ->get();

        if ($expiredShops->isEmpty()) {
            $this->info("لا توجد اشتراكات منتهية بحاجة للتعطيل.");
            return 0;
        }

        $count = 0;
        foreach ($expiredShops as $shop) {
            $this->line("تعطيل المتجر: [{$shop->shop_name}] - كود الدعم: [{$shop->shop_code}] - تاريخ الانتهاء: [{$shop->end_date}]");

            $shop->update([
                'active' => 0,
                'is_live' => 0,
            ]);

            // Sync with merchant panel (badrshop46): set run_date to NULL when expired/inactive
            if (!empty($shop->admin_link_api)) {
                $syncRes = BadrSubscriptionService::syncSubscription(
                    $shop->admin_link_api,
                    $shop->shop_code,
                    null
                );

                $statusMsg = $syncRes['status'] ? 'نجحت المزامنة وتصفير run_date لـ NULL' : ('فشلت المزامنة: ' . ($syncRes['message'] ?? ''));
                $this->line("   -> مزامنة لوحة التاجر: {$statusMsg}");
            }

            Log::info("Auto-disabled expired subscription for shop: {$shop->shop_name} (Code: {$shop->shop_code})");
            $count++;
        }

        $this->info("تم تعطيل {$count} اشتراك منتهي بنجاح.");
        return 0;
    }
}
