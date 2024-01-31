<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class DropItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('items');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('ip');
            $table->unsignedBigInteger('contractor_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('floor_plan_id');
            $table->string('color')->nullable();
            $table->string('comment')->nullable();
            $table->timestamps();
        });
    }
}
