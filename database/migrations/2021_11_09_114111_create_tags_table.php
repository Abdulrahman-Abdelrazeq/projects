<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration {

	public function up()
	{
		Schema::create('tags', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('lang_id')->unsigned();
			$table->string('name', 255);
			$table->text('description');
			$table->integer('created_by');
			$table->boolean('enabled')->default(1);
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('tags');
	}
}
