<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Module extends Model
{
    public $timestamps = false;

    protected $with = ['childs'];

    protected $casts = [
        'module_id' => 'integer',
        'priority' => 'integer',
        'api' => 'boolean',
        'active' => 'boolean',
    ];

    protected $fillable = [
        'name',
        'url',
        'icon',
        'priority',
        'description',
        'api',
        'active',
        'module_id',
    ];

    public function childs()
    {
        return $this->hasMany(Module::class)
            ->orderBy('priority', 'DESC');
    }
}
