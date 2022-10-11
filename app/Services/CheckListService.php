<?php

namespace App\Services;

use App\Models\CheckList;

class CheckListService
{
    public function sync_checklists(
        CheckList $checkList,
        int $user_id
    ): CheckList
    {
        $list = CheckList::firstOrCreate(
            [
                'user_id' => $user_id,
                'check_list_id' => $checkList->id,
            ],
            [
                'name' => $checkList->name,
                'description' => $checkList->description,
                'check_list_group_id' => $checkList->check_list_group_id,
            ]
        );
        $list->touch();
        return $list;
    }
}