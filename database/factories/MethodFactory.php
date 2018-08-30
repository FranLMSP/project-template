<?php

use Faker\Generator as Faker;

$factory->define(App\Method::class, function (Faker $faker) {
    $methods = [
        ['name' => 'GET', 'description' => 'Listar/Obtener'],
        ['name' => 'POST', 'description' => 'Crear'],
        ['name' => 'PUT', 'description' => 'Modificar'],
        ['name' => 'DELETE', 'description' => 'Borrar']
    ];

    $key = $faker->numberBetween(0,3);

    return [
        'name' => $methods[$key]['name'],
        'description' => $methods[$key]['description'],
    ];
});
