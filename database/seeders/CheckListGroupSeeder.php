<?php

namespace Database\Seeders;

use App\Models\CheckListGroup;
use Illuminate\Database\Seeder;

class CheckListGroupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $groupsCount = max((int)$this->command->ask("How many checklist groups would you like ?", 3), 1);
        CheckListGroup::factory($groupsCount)->create();
    }
}
