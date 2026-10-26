<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAyatTable extends Migration {

	public function up()
	{
		Schema::create('ayat', function(Blueprint $table) {
			$table->increments('id');
			$table->integer('sura_id')->unsigned();
			$table->integer('ayah');
			$table->text('simple');
			$table->text('text_ar');
			$table->text('text_en')->nullable();
			$table->text('text_fr')->nullable();
			$table->text('text_sp')->nullable();
			$table->text('explain_ar')->nullable();
			$table->text('explain_en')->nullable();
			$table->text('explain_fr')->nullable();
			$table->text('explain_sp');
			$table->smallInteger('juz');
			$table->smallInteger('hezb');
			$table->smallInteger('page');
			$table->integer('rub');
			$table->string('verse_key', 50);
			$table->string('vedio', 255)->nullable();
			$table->integer('created_by')->nullable();
			$table->timestamps();
		});
	}

	public function down()
	{
		Schema::drop('ayat');
	}
}
