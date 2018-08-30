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
            UsersTableSeeder::class,
            ModulesTableSeeder::class,
            MethodsTableSeeder::class,
            RolesTableSeeder::class,
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
