<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateImportersToProductCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('importers_to_product_categories', function (Blueprint $table) {
            $table->integer('importer_id')->unsigned();
            $table->integer('product_category_id')->unsigned();
            $table->foreign('importer_id')->references('id')->on('importers');
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
        Schema::table('importers_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('importers_to_product_categories_product_category_id_foreign');
      });
        Schema::table('importers_to_product_categories', function (Blueprint $table) {
          $table->dropForeign('importers_to_product_categories_importer_id_foreign');
      });
        Schema::dropIfExists('importers_to_product_categories');
    }
}
