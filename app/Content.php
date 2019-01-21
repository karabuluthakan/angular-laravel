<?php

namespace App;

use App\Helpers\Formatting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Content extends Model
{
    protected $table = 'contents';
    protected $fillable = [
        'type', 'slug', 'title', 'description', 'body', 'author_id', 'created_by', 'upated_by', 'created_at', 'updated_at', 'is_sticky', 'status'
    ];

    const TYPE_POST = 1;
    const TYPE_PAGE = 2;

    public static function boot()
    {
        parent::boot();

        static::creating(function($table)  {
            if (empty($table->slug))
                $table->slug = Formatting::sanitizeTitle($table->title);

            if (empty($table->author_id))
                $table->author_id = Auth::user()->id;

            if (Auth::user()) {
                $table->created_by = Auth::user()->id;
                $table->updated_by = Auth::user()->id;
            }
        });

        static::updating(function($table)  {
            if (Auth::user())
                $table->updated_by = Auth::user()->id;
        });
    }

    public function content_term()
    {
        return $this->hasMany('App\ContentTerm');
    }
}
