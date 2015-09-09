<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class WorkExperience extends Model
{
    protected $table = 'workExperience';

    protected $fillable = ['name', 'description'];

    public function image()
    {
        return $this->hasOne('Image');
    }
}
