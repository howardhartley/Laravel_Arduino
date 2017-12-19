<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('stations', function (Blueprint $table) {
            $table->increments('id');
            $table->string('unique')->unique();
            $table->string('name')->unique();
            $table->integer('user_id')->unsigned()->index();
            $table->boolean('is_active')->default(0);
            $table->boolean('is_private')->default(0);
            $table->string('description');
            $table->string('location');
            $table->timestamps();



            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');


        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('stations');
    }
}
