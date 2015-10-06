<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;
use Portfolio\Services\ApiFileService;

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

        static::deleting(function($projlet) { // before delete() method call this
            $image = new Image();
            $image
                ->where('parentSection', '=', 'project')
                ->where('parentId', '=', $projlet->id)->first();
            if ($image) {
                $fileService = new ApiFileService($image->parentSection, $image->parentId);
                $fileService->handleImageDelete($image->id);
            }
            $project->skillTags()->delete();
        });
    }
}
