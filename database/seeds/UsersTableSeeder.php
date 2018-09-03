<?php

use Illuminate\Database\Seeder;
use App\User;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::truncate();

        factory(User::class)->create([
            'id' => 1,
            'username' => 'admin',
            'email' => 'admin@root.com',
            'password' => bcrypt('admin1234'),
            'role_id' => 1,
        ]);
    }
}
