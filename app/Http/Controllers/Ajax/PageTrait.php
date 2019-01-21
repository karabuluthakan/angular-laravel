<?php

namespace App\Http\Controllers\Ajax;

use App\Content;
use App\Facades\System;
use Illuminate\Support\Facades\Validator;

trait PageTrait
{
    protected function pageIndex()
    {
        switch ($this->request->get('job')) {
            case 'createPage':
                return $this->createPage();
                break;

            case 'getPage':
                return $this->getPage();
                break;

            case 'getPages':
                return $this->getPages();
                break;
        }

        return false;
    }

    protected function createPage()
    {
        $data = $this->request->get('data');
        $validator = Validator::make($data, [
            'id' => 'integer|min:0',
            'title' => 'required',
            'body' => 'required',
            'status' => 'integer',
            'parent' => 'integer'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 0,
                'message' => $validator->messages()->first()
            ];
        }

        $data['type'] = Content::TYPE_PAGE;
        if ($data['id'] > 0) { // Edit
            $page = Content::find($data['id']);

            if (!$page) {
                return [
                    'status' => 0,
                    'message' => 'Düzenlenmek istenen sayfa bulunamadı'
                ];
            }

            $page->update($data);
        } else { // Create
            $page = Content::create($data);
        }

        if (!$page) {
            return [
                'status' => 0,
                'message' => 'Sayfa kaydedilirken bir hata oluştu'
            ];
        }

        return [
            'status' => 1,
            'message' => 'Sayfa başarıyla kaydedildi'
        ];
    }

    protected function getPage()
    {
        $data = $this->request->get('data');
        $page = Content::where('type', Content::TYPE_PAGE)
            ->where('id', $data['id'])
            ->first();

        if (!$page) {
            return [
                'status' => 0,
                'message' => 'Sayfa bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'data' => [
                'page' => [
                    'id' => $page->id,
                    'title' => $page->title,
                    'description' => $page->description,
                    'body' => $page->body,
                    'parent' => $page->parent ? $page->parent : 0,
                    'status' => $page->status
                ]
            ]
        ];
    }

    protected function getPages()
    {
        $_pages = Content::where('type', Content::TYPE_PAGE)
            ->paginate(30);

        $pageLinks = System::pageLinks([
            'total' => $_pages->total(),
            'per_page' => $_pages->perPage(),
            'current_page' => $_pages->currentPage(),
            'last_page' => $_pages->lastPage()
        ]);

        $pages = [];
        foreach ($_pages as $page) {
            $pages[] = [
                'id' => $page->id,
                'title' => $page->title,
                'author_id' => $page->author_id,
                'created_at' => $page->created_at->format('Y-m-d H:i:s'),
                'parent' => $page->parent ? $page->parent : 0,
                'status' => $page->status
            ];
        }

        if (empty($pages)) {
            return [
                'status' => 0,
                'message' => 'Sayfa bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'data' => [
                'pages' => $pages
            ],
            'pageLinks' => $pageLinks
        ];
    }
}
