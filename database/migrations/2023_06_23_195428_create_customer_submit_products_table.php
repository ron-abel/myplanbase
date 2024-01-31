<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCustomerSubmitProductsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('customer_submit_products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("customer_submit_id");
            $table->unsignedBigInteger("pdt_group_id");
            $table->unsignedBigInteger("pdt_id");
            $table->string("pdt_interior_color")->nullable();
            $table->string("pdt_exterior_color")->nullable();
            $table->string("pdt_door_color")->nullable();
            $table->string("customer_comment")->nullable();
            $table->float("pdt_price");
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('customer_submit_products');
    }
}
