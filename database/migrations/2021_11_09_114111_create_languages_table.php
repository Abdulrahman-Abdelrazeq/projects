<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateLanguagesTable extends Migration {

	public function up()
	{
		Schema::create('languages', function(Blueprint $table) {
			$table->increments('id');
			$table->string('language_ar', 255);
			$table->string('mother_tongue', 255);
			$table->string('icon', 255);
			$table->boolean('enabled')->default(1);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('languages');
	}
}
