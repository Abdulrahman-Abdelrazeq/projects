<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateArticleTagTable extends Migration {

	public function up()
	{
		Schema::create('article_tag', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('article_id')->unsigned();
			$table->integer('tag_id')->unsigned();
			$table->boolean('enabled')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('article_tag');
	}
}
