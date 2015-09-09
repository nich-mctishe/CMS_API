<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Image extends Model
{
    protected $table = 'images';

    protected $fillable = ['fileName', 'folderLocation', 'parentId', 'parentSection', 'local'];

    public function client() {
        return $this->belongsTo('Client');
    }

    public function project() {
        return $this->belongsTo('Project');
    }

    public function projlet() {
        return $this->belongsTo('Projlet');
    }

    public function workExperience() {
        return $this->belongsTo('WorkExperience');
    }
}
