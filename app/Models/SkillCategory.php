<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class SkillCategory extends Model
{
    protected $table = 'skillCategories';

    protected $fillable = ['name'];

    public function skills()
    {
        return $this->hasMany('Skill');
    }
}
