<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorFloorPlan extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractor_floor_plan', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("contractor_id");
            $table->unsignedBigInteger("floor_plan_id");
            $table->enum("is_keep_same_name", [0, 1])->default(1);
            $table->string("floor_plan_rename")->nullable();
            $table->enum("is_not_display_price", [0, 1])->default(0);
            $table->float("floor_plan_price")->nullable();
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
        Schema::dropIfExists('contractor_floor_plan');
    }
}
