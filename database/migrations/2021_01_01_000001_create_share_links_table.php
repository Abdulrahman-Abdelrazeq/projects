<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShareLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('share_links', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('from_shop_id')->index();
            $table->unsignedInteger('to_shop_id')->index();
            $table->unsignedInteger('from_client_id')->index();
            $table->unsignedInteger('to_client_id')->index();
            $table->text('link');
            $table->timestamp('date')->useCurrent();
            $table->unsignedInteger('bill_id')->nullable()->index();
            $table->boolean('is_done')->default(0);
            $table->unsignedInteger('commission')->default(0);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('share_links');
    }
}

