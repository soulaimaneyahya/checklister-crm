<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckList extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description',
        'check_list_group_id',
        'user_id',
        'check_list_id'
    ];
    
    public function checkListGroup()
    {
        return $this->belongsTo(CheckListGroup::class);
    }

    public function tasks()
    {
        return $this->hasMany(Task::class);
    }

    public function completed_tasks_count()
    {
        return $this->hasMany(Task::class)
        ->where('user_id', auth()->id())
        ->whereNotNull('completed_at');
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function(CheckList $list){
            $list->tasks()->delete();
        });
        static::restoring(function(CheckList $list){
            $list->tasks()->restore();
        });
    }
}
