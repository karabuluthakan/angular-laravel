<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Meta extends Model
{
    protected $table = 'metas';
    protected $fillable = [
        'type', 'entity_id', 'key', 'value', 'created_at', 'updated_at'
    ];
}
