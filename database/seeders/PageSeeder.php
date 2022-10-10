<?php

namespace Database\Seeders;

use App\Models\Page;
use Illuminate\Database\Seeder;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        /*
        $pagesCount = max((int)$this->command->ask("How many checklist pages would you like ?", 2), 1);
        Page::factory($pagesCount)->create();
        */
        $welcome = Page::factory()->welcome()->create();
        $consultation = Page::factory()->consultation()->create();
    }
}
