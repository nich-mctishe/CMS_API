<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $table = 'projects';

    protected $fillable = ['title', 'description', 'moreInfo'];

    public function images()
    {
        return $this->hasMany('Portfolio\Models\Image', 'parentId', 'id')->where('parentSection', '=', 'project');
    }

    public function skillTags()
    {
        return $this->hasMany('Portfolio\Models\SkillTag', 'projectId', 'id');
    }

    public function withDependencies()
    {
        return $this->with(['images', 'skillTags']);
    }

    // this is a recommended way to declare event handlers <-- check if this works.
    protected static function boot() {
        parent::boot();

        static::deleting(function($project) { // before delete() method call this
            $project->images()->delete();
            $project->skillTags()->delete();
        });
    }
}
