<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;
use Portfolio\Services\ApiFileService;

class WorkExperience extends Model
{
    protected $table = 'workExperience';

    protected $fillable = ['name', 'description', 'dateStarted', 'dateEnded', 'role'];

    public function image()
    {
        return $this->hasOne('Portfolio\Models\Image', 'parentId', 'id')->where('parentSection', '=', 'workExperience');
    }

    public function withDependencies()
    {
        return $this->with('image');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($workExperience) { // before delete() method call this
            $image = new Image();
            $image
                ->where('parentSection', '=', 'project')
                ->where('parentId', '=', $workExperience->id)->first();
            if ($image->id) {
                $fileService = new ApiFileService($image->parentSection, $image->parentId);
                $fileService->handleImageDelete($image->id);
            }
        });
    }
}
