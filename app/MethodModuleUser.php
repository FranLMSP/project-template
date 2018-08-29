<?php

namespace App;

use Illuminate\Database\Eloquent\Relations\Pivot;

class MethodModuleUser extends Pivot
{
    protected $fillable = [
        'method_id',
        'module_id',
        'user_id'
    ];

    protected $casts = [
        'method_id' => 'integer',
        'module_id' => 'integer',
        'user_id' => 'integer'
    ];

    public function method()
    {
        $this->belongsTo(Method::class);
    }

    public function module()
    {
        $this->belongsTo(Module::class);
    }

    public function user()
    {
        $this->belongsTo(User::class);
    }

}
