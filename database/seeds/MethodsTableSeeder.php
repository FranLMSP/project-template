<?php

use Illuminate\Database\Seeder;

use App\Method;

class MethodsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Method::truncate();

        factory(Method::class)->create([
            'id' => 1,
            'name' => 'GET',
            'description' => 'Obtener',
        ]);
        factory(Method::class)->create([
            'id' => 2,
            'name' => 'POST',
            'description' => 'Crear',
        ]);
        factory(Method::class)->create([
            'id' => 3,
            'name' => 'PUT',
            'description' => 'Modificar',
        ]);
        factory(Method::class)->create([
            'id' => 4,
            'name' => 'DELETE',
            'description' => 'Borrar',
        ]);

    }
}
