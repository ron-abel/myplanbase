<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class UpdateUserRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('user_roles', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_roles MODIFY COLUMN user_role_name ENUM('Super Admin', 'Tenant Owner', 'Tenant Manager', 'Client User')");
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
        Schema::table('user_roles', function (Blueprint $table) {
            DB::statement("ALTER TABLE user_roles MODIFY COLUMN user_role_name VARCHAR(255) UNIQUE");
            $table->dropSoftDeletes();
        });
    }
}
