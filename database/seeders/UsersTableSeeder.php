<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::create([
            'name' => 'Prayogo Bagus Suntoro',
            'username' => 'pbs81',
            'password' => bcrypt('password'),
            'email' => 'prayogosuntoro@gmail.com',
            'email_verified_at' => NOW(),
        ]);
    }
}
