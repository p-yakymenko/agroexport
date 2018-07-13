<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateExportersToProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('exporters_to_product_categories', function (Blueprint $table) {
            $table->integer('exporter_id')->unsigned();
            $table->integer('product_category_id')->unsigned();
            $table->foreign('exporter_id')->references('id')->on('exporters');
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
        Schema::table('exporters_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('exporters_to_product_categories_product_category_id_foreign');
      });
        Schema::table('exporters_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('exporters_to_product_categories_exporter_id_foreign');
      });
        Schema::dropIfExists('exporters_to_product_categories');
    }
}
