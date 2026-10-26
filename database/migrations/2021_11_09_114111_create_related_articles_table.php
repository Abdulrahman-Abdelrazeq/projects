<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRelatedArticlesTable extends Migration {

	public function up()
	{
		Schema::create('related_articles', function(Blueprint $table) {
			$table->increments('id');
			$table->timestamps();
			$table->integer('article_id')->unsigned()->nullable();
			$table->integer('anthor_article_id')->unsigned()->nullable();
			$table->boolean('enabled')->default(1);
		});
	}

	public function down()
	{
		Schema::drop('related_articles');
	}
}
