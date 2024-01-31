<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateCustomerSubmitProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_submit_products', function (Blueprint $table) {
            $table->dropColumn("pdt_interior_color");
            $table->dropColumn("pdt_exterior_color");
            $table->dropColumn("pdt_door_color");
            $table->string("pdt_color");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('customer_submit_products', function (Blueprint $table) {
            $table->string("pdt_interior_color")->nullable();
            $table->string("pdt_exterior_color")->nullable();
            $table->string("pdt_door_color")->nullable();
            $table->dropColumn("pdt_color");
        });
    }
}
