<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Menu extends Model
{
    protected $table = 'menus';
    protected $fillable = [
        'position', 'name', 'parameters', 'status', 'created_at', 'updated_at'
    ];

    const STATUS_ACTIVE = 1;
    const STATUS_PASSIVE = 0;
}
