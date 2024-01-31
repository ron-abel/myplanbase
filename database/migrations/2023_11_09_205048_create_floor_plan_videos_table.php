<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFloorPlanVideosTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('floor_plan_videos', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger("floor_plan_id");
            $table->string("vid_name");
            $table->string("vid_url");
            $table->integer("vid_key");
            $table->softDeletes();
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
        Schema::dropIfExists('floor_plan_videos');
    }
}
