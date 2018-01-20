<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFbMigrations extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fb_pages', function (Blueprint $table) {
            $table->increments('id');
            $table->string('page_id');
            $table->string('url');
            $table->string('access_token');
            $table->timestamps();
        });

        Schema::create('fb_reviews', function (Blueprint $table) {
            $table->increments('id');
            $table->string('fb_page_id');
            $table->string('hash');
            $table->text('user');
            $table->text('text');
            $table->float('rating');
            $table->string('date');
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
        Schema::dropIfExists('fb_pages');
        Schema::dropIfExists('fb_reviews');
    }
}
