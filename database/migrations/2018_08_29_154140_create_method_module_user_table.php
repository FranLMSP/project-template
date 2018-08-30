<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMethodModuleUserTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('method_module_user', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->unsignedInteger('method_id');
            $table->unsignedInteger('module_id');
            $table->unsignedInteger('user_id');
            $table->timestamps();

            $table->foreign('method_id')->references('id')->on('methods')->onDelete('cascade');
            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        //Temporalmente inhabilitado, no funciona
        //DB::statement("ALTER TABLE methods COMMENT = 'Tabla que relaciona que metodo HTTP puede hacer el usuario sobre una ruta'");
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
            $table->dropForeign(['user_id']);
        });
        Schema::dropIfExists('method_module_user');
    }
}
