<?php

namespace App;

use App\Helpers\Formatting;
use Illuminate\Database\Eloquent\Model;

class Term extends Model
{
    protected $table = 'terms';
    protected $fillable = [
        'type', 'slug', 'name', 'description', 'parent', 'created_at', 'updated_at'
    ];

    const TYPE_CATEGORY = 1;
    const TYPE_TAG = 2;

    public static function boot()
    {
        parent::boot();

        static::creating(function($table)  {
            if (empty($table->slug))
                $table->slug = Formatting::sanitizeTitle($table->name);
        });

        static::updating(function($table)  {
            if (empty($table->slug))
                $table->slug = Formatting::sanitizeTitle($table->name);
        });
    }

    public static function getTermsList($terms, array $options = [])
    {
        $options = array_merge([
            'parent' => 0,
            'level' => 0,
            'emptyElement' => false,
            'parent_title' => '',
            'template' => 'option'
        ], $options);

        $_terms = $options['emptyElement'] ? ['' => ''] : [];
        foreach ($terms as $term) {
            if ($term->parent != $options['parent'])
                continue;

            $title = $options['parent_title'];
            if (!empty($title))
                $title .= ' / ';

            $title .= $term->name;
            if ($options['template'] == 'option')
                $_terms[$term->id] = $title;
            elseif ($options['template'] == 'value-label')
                $_terms[] = ['value' => $term->id, 'label' => $title];

            $_subterms = self::getTermsList($terms, [
                'parent' => $term->id,
                'level' => $options['level'] + 1,
                'parent_title' => $title,
                'template' => $options['template']
            ]);

            if (!empty($_subterms))
                $_terms += $_subterms;

            unset($_subterms, $title);
        }

        return $_terms;
    }
}
