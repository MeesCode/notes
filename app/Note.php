<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Note extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'title', 'text', 'archived', 'pinned', 'color', 'file'
    ];

}
