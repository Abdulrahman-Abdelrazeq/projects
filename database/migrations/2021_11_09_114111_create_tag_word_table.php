<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagWordTable extends Migration {

	public function up()
	{
		Schema::create('tag_word', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('tag_id')->unsigned();
			$table->integer('word_id')->unsigned();
			$table->boolean('enabled')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('tag_word');
	}
}
