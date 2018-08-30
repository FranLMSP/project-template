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
            'name' => 'GET',
            'description' => 'Obtener',
        ]);
        factory(Method::class)->create([
            'name' => 'POST',
            'description' => 'Crear',
        ]);
        factory(Method::class)->create([
            'name' => 'PUT',
            'description' => 'Modificar',
        ]);
        factory(Method::class)->create([
            'name' => 'DELETE',
            'description' => 'Borrar',
        ]);
    }
}
