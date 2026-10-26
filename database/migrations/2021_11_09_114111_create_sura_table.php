<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSuraTable extends Migration {

	public function up()
	{
		Schema::create('sura', function(Blueprint $table) {
			$table->increments('id');
			$table->string('sura_ar', 255);
			$table->string('sura_en', 255)->nullable();
			$table->string('sura_fr', 255)->nullable();
			$table->string('sura_sp', 255)->nullable();
			$table->string('sajda', 1)->nullable();
			$table->string('ayah', 10);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('sura');
	}
}
