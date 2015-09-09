<?php

namespace Portfolio\Models;

use Illuminate\Database\Eloquent\Model;

class Client extends Model
{
    protected $table = 'clients';

    protected $fillable = ['id', 'name', 'description', 'dateStarted', 'dateEnded', 'role'];

    public function image()
    {
        return $this->hasOne('Image');
    }

}
