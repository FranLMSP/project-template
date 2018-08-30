<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMethodModuleRoleTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('method_module_role', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('method_id');
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('role_id');
            $table->timestamps();

            $table->foreign('method_id')->references('id')->on('methods')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('role_id')->references('id')->on('roles')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('modules', function($table) {
            $table->dropForeign(['method_id']);
            $table->dropForeign(['module_id']);
            $table->dropForeign(['role_id']);
        });
        Schema::dropIfExists('method_module_role');
    }
}
