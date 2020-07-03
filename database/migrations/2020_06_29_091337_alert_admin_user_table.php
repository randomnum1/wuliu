<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class AlertAdminUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->string('real_name',50)->after('password')->nullable();
            $table->string('phone',50)->after('real_name')->nullable();
            $table->string('openid',50)->after('phone')->nullable();
            $table->string('role',50)->after('openid')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('admin_users', function (Blueprint $table) {
            $table->dropColumn(['real_name','phone','openid', 'role']);
        });
    }
}
