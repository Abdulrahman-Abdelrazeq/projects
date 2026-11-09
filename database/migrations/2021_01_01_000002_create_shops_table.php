<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateShopsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->string('shop_name', 100);
            $table->text('image')->nullable();
            $table->string('link_api', 100);
            $table->string('shop_code', 50);
            $table->string('address', 255)->nullable();
            $table->integer('active')->default(1);
            $table->timestamps();
            $table->boolean('is_live')->default(1);
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('shops');
    }
}

