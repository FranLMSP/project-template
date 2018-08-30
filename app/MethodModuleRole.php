<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MethodModuleRole extends Pivot
{
    protected $fillable = [
        'method_id',
        'module_id',
        'role_id'
    ];

    protected $casts = [
        'method_id' => 'integer',
        'module_id' => 'integer',
        'role_id' => 'integer'
    ];

    public function method()
    {
        return $this->belongsTo(Method::class);
    }

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function role()
    {
        return $this->belongsTo(Role::class);
    }
}
