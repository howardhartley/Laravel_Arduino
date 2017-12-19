<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCategoryStationTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('category_station', function (Blueprint $table) {
            $table->integer('category_id')->unsigned()->index();
            $table->integer('station_id')->unsigned()->index();
            $table->timestamps();



            $table->foreign('category_id')->references('id')->on('categories')->onDelete('cascade');
            $table->foreign('station_id')->references('id')->on('stations')->onDelete('cascade');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('category_station');
    }
}
