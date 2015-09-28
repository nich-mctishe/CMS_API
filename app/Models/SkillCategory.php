<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    protected $table = 'skillCategories';

    protected $fillable = ['name'];

    public function skills()
    {
        return $this->hasMany('Portfolio\Models\Skill', 'categoryId', 'id');
    }

    public function withDependencies()
    {
        return $this->with('skills');
    }

    // this is a recommended way to declare event handlers <-- check if this works.
    protected static function boot() {
        parent::boot();

        static::deleting(function($skillCategory) { // before delete() method call this
            $skillCategory->skills()->delete();
        });
    }
}
