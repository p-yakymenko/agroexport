<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateManufacturersToProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('manufacturers_to_product_categories', function (Blueprint $table) {
            $table->integer('manufacturer_id')->unsigned();
            $table->integer('product_category_id')->unsigned();
            $table->foreign('manufacturer_id')->references('id')->on('manufacturers');
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
        Schema::table('manufacturers_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('manufacturers_to_product_categories_product_category_id_foreign');
      });
        Schema::table('manufacturers_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('manufacturers_to_product_categories_manufacturer_id_foreign');
      });
        Schema::dropIfExists('manufacturers_to_product_categories');
    }
}
