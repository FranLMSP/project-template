<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0;');

        $this->callMany([
            RolesTableSeeder::class,
            UsersTableSeeder::class,
            MethodsTableSeeder::class,
            ModulesTableSeeder::class,
            UsersPermissionsSeeder::class,
        ]);

        DB::statement('SET FOREIGN_KEY_CHECKS=1;');
    }

    private function callMany($classes)
    {
        foreach($classes as $class) {
            $this->call($class);
        }
    }
}
