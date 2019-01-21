<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MenuLink extends Model
{
    protected $table = 'menu_links';
    protected $fillable = [
        'menu_id', 'type', 'route', 'permalink', 'label', 'icon', 'parent', 'perm', 'sort', 'parameters', 'created_at', 'updated_at', 'status'
    ];

    const TYPE_LINK = 1;
    const TYPE_SEPARATOR = 2;

    const STATUS_ACTIVE = 1;
    const STATUS_PASSIVE = 0;
}
