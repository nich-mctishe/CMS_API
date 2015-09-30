<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Projlet extends Model
{
    public static $snakeAttributes = false;

    protected $table = 'projlets';

    protected $fillable = ['title', 'description'];

    public function images()
    {
        return $this->hasMany('Portfolio\Models\Image', 'parentId', 'id')->where('parentSection', '=', 'projlet');
    }

    public function skillTags()
    {
        return $this->hasMany('Portfolio\Models\SkillTag', 'projectId', 'id')->with('skill');
    }

    public function withDependencies()
    {
        return $this->with(['images', 'skillTags']);
    }

    // this is a recommended way to declare event handlers <-- check if this works.
    protected static function boot() {
        parent::boot();

        static::deleting(function($project) { // before delete() method call this
            $project->images()->where('parentSection', '=', 'projlet')->delete();
            $project->skillTags()->delete();
        });
    }
}
