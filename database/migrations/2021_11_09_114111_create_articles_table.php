<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticlesTable extends Migration {

	public function up()
	{
		Schema::create('articles', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('lang_id')->unsigned();
			$table->string('name', 255);
			$table->text('description');
			$table->integer('created_by');
			$table->boolean('enabled')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('articles');
	}
}
