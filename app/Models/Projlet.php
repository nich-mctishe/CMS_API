<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Projlet extends Model
{
    protected $table = 'projlets';

    protected $fillable = ['title', 'description'];

    public function images()
    {
        return $this->hasMany('Image');
    }

    public function skillTags()
    {
        return $this->hasMany('SkillTag');
    }
}
