<?php

namespace ImagesManager;

use Illuminate\Database\Eloquent\Model;

class Album extends Model
{
    // name of the database table
    protected $table = 'albums';

    protected $fillable = ['id', 'title', 'description', 'user_id'];


    // relationships to the Owner of an album
    // if album belongs to a User, it needs to have a user)_id
    public function owner()
    {
        return belongsTo('ImagesManager\User');
    }

    // relationships
    public function photos()
    {
        return hasMany('ImagesManager\Photo');
    }

}
