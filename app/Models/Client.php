<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;
use Portfolio\Services\ApiFileService;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = ['name', 'desc', 'dateStarted', 'dateEnded', 'role'];

    public function image()
    {
        return $this->hasOne('Portfolio\Models\Image', 'parentId', 'id')->where('parentSection', '=', 'client');
    }

    public function withDependencies()
    {
        return $this->with('image');
    }

    protected static function boot() {
        parent::boot();

        static::deleting(function($client) { // before delete() method call this
            $image = new Image();
            $image
                ->where('parentSection', '=', 'project')
                ->where('parentId', '=', $client->id)->first();
            if ($image->id) {
                $fileService = new ApiFileService($image->parentSection, $image->parentId);
                $fileService->handleImageDelete($image->id);
            }
        });
    }
}
