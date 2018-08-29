<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Method extends Model
{
    public $timestamps = false;

    protected $fillable = [
        'name',
        'description',
    ];
}
