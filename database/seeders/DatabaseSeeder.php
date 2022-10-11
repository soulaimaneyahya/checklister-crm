<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
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
        if( $this->command->confirm("Do You want to refresh the DB ?")){
            $this->command->call('migrate:refresh');
            $this->command->info('---------------------------------- database refreshed');
        }

        $this->call([
            UserSeeder::class,
            PageSeeder::class,
            CheckListGroupSeeder::class,
            CheckListSeeder::class,
            TaskSeeder::class,
            PaymentSeeder::class,
        ]);
        $this->command->info("---------------------------------- thanks seeder");
    }
}
