<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateFarmsToProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('farms_to_product_categories', function (Blueprint $table) {
            $table->integer('farm_id')->unsigned();
            $table->integer('product_category_id')->unsigned();
            $table->foreign('farm_id')->references('id')->on('farms');
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
        Schema::table('farms_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('farms_to_product_categories_product_category_id_foreign');
      });
        Schema::table('farms_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('farms_to_product_categories_farm_id_foreign');
      });
        Schema::dropIfExists('farms_to_product_categories');
    }
}
