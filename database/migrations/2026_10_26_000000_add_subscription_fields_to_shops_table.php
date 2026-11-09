<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddSubscriptionFieldsToShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->tinyInteger('subscription')->default(0)->after('is_live');
            $table->string('phone', 50)->nullable()->after('shop_code');
            $table->string('admin_link_api', 255)->nullable()->after('link_api');
            $table->date('start_date')->nullable()->after('address');
            $table->date('end_date')->nullable()->after('start_date');
            $table->string('shop_type', 50)->nullable()->after('end_date');
            $table->integer('sort_order')->default(0)->after('shop_type');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('shops', function (Blueprint $table) {
            $table->dropColumn([
                'subscription',
                'phone',
                'admin_link_api',
                'start_date',
                'end_date',
                'shop_type',
                'sort_order'
            ]);
        });
    }
}

