<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateContentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contents', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('status')->default('1');
            $table->boolean('comment')->default('1');
            $table->string('type');
            $table->longText('title');
            $table->string('slug');
            $table->text('description');
            $table->longText('meta_title');
            $table->text('meta_description');
            $table->longText('meta_keywords');
            $table->longText('image');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('contents');
    }
}
