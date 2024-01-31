<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateItemsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->dropColumn("interior_color");
            $table->dropColumn("exterior_color");
            $table->dropColumn("door_color");
            $table->string("color");
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('items', function (Blueprint $table) {
            $table->string('interior_color')->nullable();
            $table->string('door_color')->nullable();
            $table->string('exterior_color')->nullable();
            $table->dropColumn("color");
        });
    }
}
