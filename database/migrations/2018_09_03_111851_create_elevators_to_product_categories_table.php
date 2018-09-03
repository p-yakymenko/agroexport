<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateElevatorsToProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('elevators_to_product_categories', function (Blueprint $table) {
            $table->integer('elevator_id')->unsigned();
            $table->integer('product_category_id')->unsigned();
            $table->foreign('elevator_id')->references('id')->on('elevators');
            $table->foreign('product_category_id')->references('id')->on('product_categories'); 
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
        Schema::table('elevators_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('elevators_to_product_categories_product_category_id_foreign');
      });
        Schema::table('elevators_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('elevators_to_product_categories_elevator_id_foreign');
      });
        Schema::dropIfExists('elevators_to_product_categories');
    }
}
