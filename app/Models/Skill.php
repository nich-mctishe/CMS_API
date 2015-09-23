<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Skill extends Model
{
    protected $table = 'skills';

    protected $fillable = ['name', 'category', 'desc'];

    public function skillCategory()
    {
        $this->belongsTo('SkillCategory', 'name', 'category');
    }
}
