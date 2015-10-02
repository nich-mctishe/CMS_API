<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;
use Portfolio\Models\Image;
use Portfolio\Services\ApiFileService;

class Project extends Model
{
    public static $snakeAttributes = false;

    protected $table = 'projects';

    protected $fillable = ['title', 'description', 'moreInfo'];

    public function images()
    {
        return $this->hasMany('Portfolio\Models\Image', 'parentId', 'id')->where('parentSection', '=', 'project');
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
            $image = new Image();
            $image
                ->where('parentSection', '=', 'project')
                ->where('parentId', '=', $client->id)->first();
            if ($image) {
                $fileService = new ApiFileService($image->parentSection, $image->parentId);
                $fileService->handleImageDelete($image->id);
                $image->delete();
            }
            $project->skillTags()->delete();
        });
    }
}
