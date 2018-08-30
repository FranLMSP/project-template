<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMethodsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('methods', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->comment('Nombre del metodo HTTP (GET, POST, PUT, DELETE).');
            $table->string('description')->nullable();
        });

        //Temporalmente inhabilitado, no funciona
        //DB::statement("ALTER TABLE methods COMMENT = 'Tabla que guarda los métodos HTTP'");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('methods');
    }
}
