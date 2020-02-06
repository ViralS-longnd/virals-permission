<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::dropIfExists('user_role');
        Schema::create('user_role', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('role_id');
        });

        Schema::dropIfExists('user_permission');
        Schema::create('user_permission', function (Blueprint $table) {
            $table->bigInteger('user_id');
            $table->bigInteger('permission_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_role');
        Schema::dropIfExists('user_permission');
    }
}
