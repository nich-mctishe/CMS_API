<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['fileName', 'folderLocation', 'parentId', 'parentSection', 'local'];

    public function client() {
        return $this->belongsTo('Portfolio\Models\Client');
    }

    public function project() {
        return $this->belongsTo('Portfolio\Models\Project');
    }

    public function projlet() {
        return $this->belongsTo('Portfolio\Models\Projlet');
    }

    public function workExperience() {
        return $this->belongsTo('Portfolio\Models\WorkExperience');
    }
}
