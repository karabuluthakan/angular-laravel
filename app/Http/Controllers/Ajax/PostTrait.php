<?php

namespace App\Http\Controllers\Ajax;

use App\Content;
use App\ContentTerm;
use App\Facades\System;
use Illuminate\Support\Facades\Validator;

trait PostTrait
{
    protected function postIndex()
    {
        switch ($this->request->get('job')) {
            case 'createPost':
                return $this->createPost();
                break;

            case 'getPost':
                return $this->getPost();
                break;

            case 'getPosts':
                return $this->getPosts();
                break;
        }

        return false;
    }

    protected function createPost()
    {
        $data = $this->request->get('data');
        $validator = Validator::make($data, [
            'id' => 'integer|min:0',
            'title' => 'required',
            'body' => 'required',
            'is_sticky' => 'min:0|max:1',
            'status' => 'integer',
        ]);

        if ($validator->fails()) {
            return [
                'status' => 0,
                'message' => $validator->messages()->first()
            ];
        }

        $data['type'] = Content::TYPE_POST;
        if ($data['id'] > 0) { // Edit
            $post = Content::find($data['id']);

            if (!$post) {
                return [
                    'status' => 0,
                    'message' => 'Düzenlenmek istenen yazı bulunamadı'
                ];
            }

            $post->update($data);
        } else { // Create
            $post = Content::create($data);
        }

        if (!$post) {
            return [
                'status' => 0,
                'message' => 'Yazı kaydedilirken bir hata oluştu'
            ];
        }

        foreach ($data['categories'] as $category_id) {
            $contentTerm = ContentTerm::where('content_id', $post->id)
                ->where('term_id', $category_id)
                ->first();

            if (!$contentTerm) {
                $contentTerm = ContentTerm::create([
                    'content_id' => $post->id,
                    'term_id' => $category_id
                ]);
            }
        }

        return [
            'status' => 1,
            'message' => 'Yazı başarıyla kaydedildi'
        ];
    }

    protected function getPost()
    {
        $data = $this->request->get('data');
        $_post = Content::where('type', Content::TYPE_POST)
            ->where('id', $data['id'])
            ->first();

        if (!$_post) {
            return [
                'status' => 0,
                'message' => 'Yazı bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'data' => [
                'post' => [
                    'id' => $_post->id,
                    'title' => $_post->title,
                    'description' => $_post->description,
                    'body' => $_post->body,
                    'author_id' => $_post->author_id,
                    'is_sticky' => $_post->is_sticky,
                    'status' => $_post->status,
                    'categories' => $_post->content_term->pluck('term_id')
                ]
            ]
        ];
    }

    protected function getPosts()
    {
        $_posts = Content::where('type', Content::TYPE_POST)
            ->paginate(30);

        $pageLinks = System::pageLinks([
            'total' => $_posts->total(),
            'per_page' => $_posts->perPage(),
            'current_page' => $_posts->currentPage(),
            'last_page' => $_posts->lastPage()
        ]);

        $posts = [];
        foreach ($_posts as $post) {
            $posts[] = [
                'id' => $post->id,
                'title' => $post->title,
                'author_id' => $post->author_id,
                'created_at' => $post->created_at->format('Y-m-d H:i:s'),
                'is_sticky' => $post->is_sticky,
                'status' => $post->status
            ];
        }

        if (empty($posts)) {
            return [
                'status' => 0,
                'message' => 'Yazı bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'data' => [
                'posts' => $posts
            ],
            'pageLinks' => $pageLinks
        ];
    }
}
