<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateWordsTable extends Migration {

	public function up()
	{
		Schema::create('words', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('ayah_id')->unsigned();
			$table->integer('sura_id')->unsigned();
			$table->integer('position');
			$table->string('verse_key', 50);
			$table->string('simple', 255);
			$table->string('word_ar', 255);
			$table->string('word_en', 255)->nullable();
			$table->string('word_fr', 255);
			$table->string('word_sp', 255)->nullable();
			$table->integer('page');
			$table->string('class_name', 255)->nullable();
			$table->integer('line')->nullable();
			$table->string('code', 100)->nullable();
			$table->string('code_v3', 100)->nullable();
			$table->string('char_type', 100)->nullable();
			$table->text('audio')->nullable();
			$table->text('vedio')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('words');
	}
}
