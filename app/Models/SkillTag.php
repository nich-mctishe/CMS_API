<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class SkillTag extends Model
{
    protected $table = 'skillTags';

    protected $fillable = ['skillId', 'projectId', 'projletId'];

    public function skill()
    {
        return $this->hasOne('Portfolio\Models\Skill', 'id', 'skillId');
    }

    public function project()
    {
        return $this->belongsTo('Portfolio\Models\Project', 'id', 'projectId');
    }

    public function projlet()
    {
        return $this->belongsTo('Portfolio\Models\Projlet', 'id', 'projletId');
    }

    public function withDependencies()
    {
        return $this->with('skill');
    }
}
