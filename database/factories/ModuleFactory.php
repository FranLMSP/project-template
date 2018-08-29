<?php

use Faker\Generator as Faker;

use App\Module;

$factory->define(Module::class, function (Faker $faker) {

    //Por defecto el modulo no tendrá hijos
    $parent = NULL;

    //Se decide al azar si el módulo tendrá hijos o no
    //Y solo si existen módulos creados
    if($faker->numberBetween(0,1) && Module::count() > 1) {
        //Se asigna un padre al azar
        $parent = Module::all()->random()->id;
    }

    return [
        'name' => $faker->word,
        'url' => $faker->word.'/',
        'icon' => 'plus',
        'priority' => $faker->numberBetween(0,100),
        'description' => $faker->sentence,
        'api' => $faker->numberBetween(0,1) ? true : false,
        'active' => true,
        'module_id' => $parent
    ];
});
