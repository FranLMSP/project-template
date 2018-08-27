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
        $this->callMany([
            UsersTableSeeder::class,
        ]);
    }

    private function callMany($classes)
    {
        foreach($classes as $class) {
            $this->call($class);
        }
    }
}
