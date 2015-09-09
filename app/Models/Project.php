<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'project';

    protected $fillable = ['title', 'description', 'moreInfo'];

    public function images()
    {
        return $this->hasMany('Image');
    }

    public function skillTags()
    {
        return $this->hasMany('SkillTag');
    }
}
