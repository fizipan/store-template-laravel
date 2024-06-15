<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $user = [
            [
                'name' => 'Admin',
                'email' => 'admin@mail.com',
                'password' => bcrypt('password'),
                'roles' => 'ADMIN',
                'created_at' => now(),
                'updated_at' => now()
            ],
        ];

        DB::table('users')->insert($user);

        $this->call(IndoRegionSeeder::class);
    }
}
