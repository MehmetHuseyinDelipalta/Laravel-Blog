<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class Articles extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('articles', function (Blueprint $table) {
            $table->bigIncrements("id");
            $table->enum('status', ['active', 'passive', 'deleted'])->default('active');
            $table->string('title', 500);
            $table->string('image');
            $table->longText('content');
            $table->string('slug', 500);
            $table->unsignedBigInteger('creator_id');
            $table->softDeletes(); // deleted_at sütununu ekler
            $table->timestamps(); // created_at ve updated_at sütunlarını ekler
            $table->timestamp('publish_date')->nullable();
            $table->foreign('creator_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('articles');
    }
}
