<?php

namespace Database\Seeders;

use App\Models\CheckList;
use App\Models\CheckListGroup;
use Illuminate\Database\Seeder;

class CheckListSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $listsCount = max((int)$this->command->ask("How many lists would you like ?", 5), 1);
        $groups = CheckListGroup::all();
        $lists = CheckList::factory($listsCount)->make()->each(function($list) use($groups) {
            $list->check_list_group_id = $groups->random()->id;
            $list->save();
        });
    }
}
