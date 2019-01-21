<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Role extends Model
{
    protected $table = 'roles';
    protected $fillable = [
        'slug', 'name', 'status', 'created_at', 'updated_at'
    ];

    public function permissions()
    {
        return $this->hasMany('App\RolePermission');
    }
}
