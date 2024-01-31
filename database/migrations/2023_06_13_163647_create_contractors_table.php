<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateContractorsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('contractors', function (Blueprint $table) {
            $table->id();
            $table->string('company_name');
            $table->string('company_website')->nullable();
            $table->string('sub_domain')->unique();
            $table->string('address')->nullable();
            $table->string('state')->nullable();
            $table->string('county')->nullable();
            $table->string('zip')->nullable();
            $table->text('logo')->nullable();
            $table->text('business_description')->nullable();
            $table->tinyInteger('has_licensed')->default(0)->nullable();
            $table->tinyInteger('has_insured')->default(0)->nullable();
            $table->tinyInteger('has_trades_selected')->default(0)->nullable();
            $table->string('work_states')->nullable();
            $table->string('work_counties')->nullable();
            $table->timestamp('deleted_at')->nullable();
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
        Schema::dropIfExists('contractors');
    }
}
