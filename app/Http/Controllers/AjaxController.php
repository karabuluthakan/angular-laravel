<?php

namespace App\Http\Controllers;

use App\Content;
use App\ContentTerm;
use App\Facades\System;
use App\Http\Controllers\Ajax\CategoryTrait;
use App\Http\Controllers\Ajax\MenuTrait;
use App\Http\Controllers\Ajax\PageTrait;
use App\Http\Controllers\Ajax\PostTrait;
use App\Http\Controllers\Ajax\UploadTrait;
use App\Http\Controllers\Ajax\UserTrait;
use App\Libraries\Elasticsearch;
use App\Term;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class AjaxController extends Controller
{
    use PostTrait, PageTrait, CategoryTrait, UploadTrait, UserTrait, MenuTrait;

    protected $request;
    protected $elasticsearch;

    public function index(Request $request, Elasticsearch $elasticsearch)
    {
        $this->request = $request;
        $this->elasticsearch = $elasticsearch;

        if (($categoryIndex = $this->categoryIndex()) !== false)
            return $categoryIndex;
        elseif (($postIndex = $this->postIndex()) !== false)
            return $postIndex;
        elseif (($pageIndex = $this->pageIndex()) !== false)
            return $pageIndex;
        elseif (($uploadIndex = $this->uploadIndex()) !== false)
            return $uploadIndex;
        elseif (($userIndex = $this->userIndex()) !== false)
            return $userIndex;
        elseif (($menuIndex = $this->menuIndex()) !== false)
            return $menuIndex;

        return [
            'status' => 0,
            'message' => 'Bir hata oluştu!'
        ];
    }
}
