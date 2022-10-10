<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class CheckListGroup extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected $fillable = [
        'name',
        'description'
    ];

    public function checklists()
    {
        return $this->hasMany(CheckList::class);
    }

    public static function boot()
    {
        parent::boot();
        static::deleting(function(CheckListGroup $group){
            $group->checklists()->delete();
        });
        static::restoring(function(CheckListGroup $group){
            $group->checklists()->restore();
        });
    }
}
