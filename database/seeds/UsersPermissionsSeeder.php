<?php

use Illuminate\Database\Seeder;

use App\MethodModuleUser;

class UsersPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Poder permisos del módulo de usuarios
        factory(MethodModuleUser::class)->create([
            'method_id' => 1, //GET
            'module_id' => 1, //Padre CONFIGURACION
            'user_id' => 1, //Usuario creado
        ]);
        factory(MethodModuleUser::class)->create([
            'method_id' => 1, //GET
            'module_id' => 2, //Hijo USUARIOS
            'user_id' => 1, //Usuario creado
        ]);
        factory(MethodModuleUser::class)->create([
            'method_id' => 1, //GET
            'module_id' => 3, //Hijo LISTAR
            'user_id' => 1, //Usuario creado
        ]);
        factory(MethodModuleUser::class)->create([
            'method_id' => 1, //GET
            'module_id' => 4, //API LISTAR
            'user_id' => 1, //Usuario creado
        ]);
        factory(MethodModuleUser::class)->create([
            'method_id' => 1, //GET
            'module_id' => 5, //API OBTENER
            'user_id' => 1, //Usuario creado
        ]);
        factory(MethodModuleUser::class)->create([
            'method_id' => 1, //GET
            'module_id' => 6, //API CREATE
            'user_id' => 1, //Usuario creado
        ]);
        factory(MethodModuleUser::class)->create([
            'method_id' => 1, //GET
            'module_id' => 7, //API GET EDIT
            'user_id' => 1, //Usuario creado
        ]);
    }
}
