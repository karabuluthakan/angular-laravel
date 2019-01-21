<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class RolePermission extends Model
{
    protected $table = 'role_permissions';
    protected $fillable = [
        'role_id', 'name', 'can_do'
    ];
}
