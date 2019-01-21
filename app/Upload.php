<?php

namespace App;

use App\Helpers\Formatting;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Auth;

class Upload extends Model
{
    protected $table = 'uploads';
    protected $fillable = [
        'id', 'file', 'file_name', 'title', 'description', 'mime', 'file_sha1', 'width', 'height', 'size', 'info', 'created_at', 'updated_at', 'created_by', 'updated_by', 'status'
    ];

    const STATUS_DISABLE = 0;
    const STATUS_ACTIVE = 1;

    public static function boot()
    {
        parent::boot();

        static::creating(function($table)  {
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

    public static function newFile($file, $folder, array $info = [])
    {
        $uploadName = explode('.', $file->getClientOriginalName());
        if (count($uploadName) > 1)
            array_pop($uploadName);

        $folder = preg_replace('/[^a-zA-Z0-9\.\/_\-]/', '', $folder);
        $uploadPath = public_path('images/' . $folder . '/');
        $ext = strtolower($file->getClientOriginalExtension());
        $uploadName = Formatting::sanitizeTitle(implode('.', $uploadName));
        for ($i = 1; true; $i++) {
            $_uploadName = $uploadName;
            if ($i != 1)
                $_uploadName .= '-' . $i;

            $_uploadName .= '.' . $ext;
            if (!file_exists($uploadPath . $_uploadName)) {
                $uploadName = $_uploadName;
                break;
            }
        }

        $sha1 = sha1_file($file->getPathName());
        $upload = Upload::where('file_sha1', $sha1)
            ->first();

        if (!$upload) {
            $upload = [
                'file' => $file->getClientOriginalName(),
                'file_name' => $uploadPath . $uploadName,
                'title' => $file->getClientOriginalName(),
                'mime' => $file->getMimeType(),
                'ext' => $ext,
                'file_sha1' => $sha1,
                'size' => $file->getSize(),
                'status' => Upload::STATUS_ACTIVE
            ];

            $file->move($uploadPath, $uploadName);
            $upload = Upload::create($upload);
        }

        return $upload;
    }
}
