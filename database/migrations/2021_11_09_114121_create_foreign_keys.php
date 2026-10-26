<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateForeignKeys extends Migration {

	public function up()
	{
		Schema::table('ayat', function(Blueprint $table) {
			$table->foreign('sura_id')->references('id')->on('sura')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('words', function(Blueprint $table) {
			$table->foreign('ayah_id')->references('id')->on('ayat')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('words', function(Blueprint $table) {
			$table->foreign('sura_id')->references('id')->on('sura')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->foreign('lang_id')->references('id')->on('languages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tags', function(Blueprint $table) {
			$table->foreign('lang_id')->references('id')->on('languages')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('article_tag', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('article_tag', function(Blueprint $table) {
			$table->foreign('tag_id')->references('id')->on('tags')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('related_articles', function(Blueprint $table) {
			$table->foreign('article_id')->references('id')->on('articles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('related_articles', function(Blueprint $table) {
			$table->foreign('anthor_article_id')->references('id')->on('articles')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tag_word', function(Blueprint $table) {
			$table->foreign('tag_id')->references('id')->on('tags')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
		Schema::table('tag_word', function(Blueprint $table) {
			$table->foreign('word_id')->references('id')->on('words')
						->onDelete('restrict')
						->onUpdate('restrict');
		});
	}

	public function down()
	{
		Schema::table('ayat', function(Blueprint $table) {
			$table->dropForeign('ayat_sura_id_foreign');
		});
		Schema::table('words', function(Blueprint $table) {
			$table->dropForeign('words_ayah_id_foreign');
		});
		Schema::table('words', function(Blueprint $table) {
			$table->dropForeign('words_sura_id_foreign');
		});
		Schema::table('articles', function(Blueprint $table) {
			$table->dropForeign('articles_lang_id_foreign');
		});
		Schema::table('tags', function(Blueprint $table) {
			$table->dropForeign('tags_lang_id_foreign');
		});
		Schema::table('article_tag', function(Blueprint $table) {
			$table->dropForeign('article_tag_article_id_foreign');
		});
		Schema::table('article_tag', function(Blueprint $table) {
			$table->dropForeign('article_tag_tag_id_foreign');
		});
		Schema::table('related_articles', function(Blueprint $table) {
			$table->dropForeign('related_articles_article_id_foreign');
		});
		Schema::table('related_articles', function(Blueprint $table) {
			$table->dropForeign('related_articles_anthor_article_id_foreign');
		});
		Schema::table('tag_word', function(Blueprint $table) {
			$table->dropForeign('tag_word_tag_id_foreign');
		});
		Schema::table('tag_word', function(Blueprint $table) {
			$table->dropForeign('tag_word_word_id_foreign');
		});
	}
}
