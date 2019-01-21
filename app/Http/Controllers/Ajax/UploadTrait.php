<?php

namespace App\Http\Controllers\Ajax;

trait UploadTrait
{
    protected function uploadIndex()
    {
        switch ($this->request->get('job')) {
            case 'uploadFile':
                return $this->uploadFile();
                break;
        }

        return false;
    }

    protected function uploadFile()
    {
        var_dump($this->request->all());

        $file = $this->request->file('file');
        var_dump($file);

        return [
            'status' => 0,
            'message' => 'Dosya yüklenirken bir hata oluştu.'
        ];
    }
}
