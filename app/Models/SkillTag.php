<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class SkillTag extends Model
{
    protected $table = 'skillTags';

    protected $fillable = ['skillId', 'projectId', 'projletId'];

    public function skill()
    {
        return $this->hasOne('Skill');
    }
}
