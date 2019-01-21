<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class ContentTerm extends Model
{
    protected $table = 'content_term';
    protected $fillable = [
        'content_id', 'term_id', 'created_at', 'updated_at'
    ];
}
