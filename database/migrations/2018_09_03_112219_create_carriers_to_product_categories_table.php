<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateCarriersToProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('carriers_to_product_categories', function (Blueprint $table) {
            $table->integer('carrier_id')->unsigned();
            $table->integer('product_category_id')->unsigned();
            $table->foreign('carrier_id')->references('id')->on('carriers');
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
        Schema::table('carriers_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('carriers_to_product_categories_product_category_id_foreign');
      });
        Schema::table('carriers_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('carriers_to_product_categories_carrier_id_foreign');
      });
        Schema::dropIfExists('carriers_to_product_categories');
    }
}
