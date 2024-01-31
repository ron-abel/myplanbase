<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateColorFieldInCustomerSubmitProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('customer_submit_products', function (Blueprint $table) {
            $table->string('pdt_color')->nullable()->change();
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
            $table->string('pdt_color')->nullable(false)->change();
        });
    }
}
