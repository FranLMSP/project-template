<?php

use Illuminate\Database\Seeder;

use App\Role;

class RolesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Role::truncate();

        factory(Role::class)->create([
            'id' => 1,
            'name' => 'Administrador',
            'description' => 'Usuario con todos los privilegios'
        ]);
    }
}
