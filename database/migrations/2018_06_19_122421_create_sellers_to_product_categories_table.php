<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSellersToProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sellers_to_product_categories', function (Blueprint $table) {
            $table->integer('seller_id')->unsigned();
            $table->integer('product_category_id')->unsigned();
            $table->foreign('seller_id')->references('id')->on('sellers');
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
        Schema::table('sellers_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('sellers_to_product_categories_product_category_id_foreign');
      });
        Schema::table('sellers_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('sellers_to_product_categories_seller_id_foreign');
      });
        Schema::dropIfExists('sellers_to_product_categories');
    }
}
