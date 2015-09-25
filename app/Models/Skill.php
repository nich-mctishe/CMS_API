<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';

    protected $fillable = ['name', 'categoryId', 'desc'];

    public function skillCategory()
    {
        return $this->belongsTo('Portfolio\Models\SkillCategory', 'categoryId', 'id');
    }

    public function withDependencies()
    {
        return $this->with('skillCategory');
    }
}
