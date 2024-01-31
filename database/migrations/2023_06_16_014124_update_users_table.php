<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('users', function (Blueprint $table) {
            $table->unsignedBigInteger("contractor_id")->nullable()->change();
            $table->unsignedBigInteger("user_role_id")->change();
            $table->timestamp("email_verified_at")->nullable();
            $table->string('admin_token')->nullable()->change();
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
        Schema::table('users', function (Blueprint $table) {
            $table->integer("contractor_id")->change();
            $table->integer("user_role_id")->change();
            $table->dropColumn("email_verified_at");
            $table->string('admin_token')->change();
            $table->dropSoftDeletes();
        });
    }
}
