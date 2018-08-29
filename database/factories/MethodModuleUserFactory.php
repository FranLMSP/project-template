<?php

use Faker\Generator as Faker;

use App\Method;
use App\Module;
use App\User;

$factory->define(App\MethodModuleUser::class, function (Faker $faker) {
    return [
        'method_id' => Method::count() > 0 ? Method::all()->random()->id : factory(Method::class)->create()->id,
        'module_id' => Module::count() > 0 ? Module::all()->random()->id : factory(Module::class)->create()->id,
        'user_id' => User::count() > 0 ? User::all()->random()->id : factory(User::class)->create()->id,
    ];
});
