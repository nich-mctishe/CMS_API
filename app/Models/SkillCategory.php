<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    protected $table = 'skillCategories';

    protected $fillable = ['name'];

    public function skills()
    {
        return $this->hasMany('Portfolio\Models\Skill', 'category', 'name');
    }

    public function withDependencies()
    {
        return $this->with('skills');
    }
}
