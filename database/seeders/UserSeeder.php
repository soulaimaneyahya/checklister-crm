<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $usersCount = max((int)$this->command->ask("How many users would you like ?",10), 1);
        $admin = \App\Models\User::factory()->admin()->create();
        $john = \App\Models\User::factory()->john()->create();
        $user = \App\Models\User::factory($usersCount)->create();
    }
}
