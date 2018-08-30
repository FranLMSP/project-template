<?php

use Faker\Generator as Faker;

use App\Method;
use App\Module;
use App\Role;

$factory->define(App\MethodModuleRole::class, function (Faker $faker) {
    return [
        'method_id' => Method::count() > 0 ? Method::all()->random()->id : factory(Method::class)->create()->id,
        'module_id' => Module::count() > 0 ? Module::all()->random()->id : factory(Module::class)->create()->id,
        'role_id' => Role::count() > 0 ? Role::all()->random()->id : factory(Role::class)->create()->id,
    ];
});
