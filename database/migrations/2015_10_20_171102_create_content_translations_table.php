<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentTranslationsTable extends Migration
{

    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('content_translations', function (Blueprint $table) {
            $table->increments('id');

            $table->string('title', 255);
            $table->string('slug', 255);
            $table->longText('body');

            $table->integer('content_id')->unsigned();
            $table->string('locale', '10')->index();
            $table->unique(['content_id', 'locale']);
            $table->unique(['slug', 'locale']);
            $table->foreign('content_id')->references('id')->on('contents')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('content_translations');
    }

}
