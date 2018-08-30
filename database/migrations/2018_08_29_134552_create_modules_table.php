<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateModulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('modules', function (Blueprint $table) {
            $table->increments('id')->unsigned();
            $table->string('name')->comment('Nombre del módulo.');
            $table->string('url')->default('/')->comment('Ruta del módulo.');
            $table->string('icon')->default('plus')->comment('Ícono del módulo (de Font Awesome sin el -fa-).');
            $table->tinyInteger('priority')->default(0)->comment('Prioridad del módulo (para ordenarlos).');
            $table->text('description')->nullable(); 
            $table->boolean('api')->default(false)->comment('Booleano para diferenciar entre las rutas de frontend y backend.');
            $table->boolean('active')->default(true)
                ->comment('Esto es solo para decidir qué modulos mostrar en el menu y cuales no. Por defecto los modulos API no se listarán.');

            $table->unsignedInteger('module_id')->nullable()->comment('Relación recursiva para el módulo padre.');

            $table->foreign('module_id')->references('id')->on('modules')->onDelete('cascade');
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
            $table->dropForeign(['module_id']);
        });
        Schema::dropIfExists('modules');
    }
}
