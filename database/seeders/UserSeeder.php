<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        User::factory(10)->create();
        User::factory()->create([
            'username' => 'admin',
            'email' => '1@1.com',
            'admin' => true
        ]);
    }
}
