<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('items', function (Blueprint $table) {
            $table->id();
            $table->string('ip')->unique();
            $table->unsignedBigInteger('contractor_id');
            $table->unsignedBigInteger('product_id');
            $table->unsignedBigInteger('floor_plan_id');
            $table->string('interior_color')->nullable();
            $table->string('door_color')->nullable();
            $table->string('exterior_color')->nullable();
            $table->string('comment')->nullable();
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
        Schema::dropIfExists('items');
    }
}
