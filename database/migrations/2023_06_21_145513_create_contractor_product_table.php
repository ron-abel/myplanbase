<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorProductTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_product', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("contractor_id");
            $table->unsignedBigInteger("product_group_id");
            $table->unsignedBigInteger("product_id");
            $table->enum("is_not_display_price", [0, 1])->default(0);
            $table->enum("is_enter_price", [0, 1])->default(0);
            $table->float("product_price")->nullable();
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
        Schema::dropIfExists('contractor_product');
    }
}
