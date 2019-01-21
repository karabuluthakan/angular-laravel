<?php

namespace App\Http\Controllers\Ajax;

use App\Term;
use Illuminate\Support\Facades\Validator;

trait CategoryTrait
{
    protected function categoryIndex()
    {
        switch ($this->request->get('job')) {
            case 'createCategory':
                return $this->createCategory();
                break;

            case 'getCategory':
                return $this->getCategory();
                break;

            case 'getCategories':
                return $this->getCategories();
                break;

            case 'getSelectCategories':
                return $this->getSelectCategories();
                break;

            case 'deleteCategory':
                return $this->deleteCategory();
                break;
        }

        return false;
    }

    protected function createCategory()
    {
        $data = $this->request->get('data');
        $validator = Validator::make($data, [
            'name' => 'required'
        ]);

        if ($validator->fails()) {
            return [
                'status' => 0,
                'message' => $validator->messages()->first()
            ];
        }

        $parent = $data['parent'];
        if (!$parent)
            $parent = null;

        if ($data['id'] > 0) {
            $term = Term::find($data['id']);

            if (!$term) {
                return [
                    'status' => 0,
                    'message' => 'Düzenlenmek istenen kategori bulunamadı!'
                ];
            }
        } else {
            $term = Term::where('parent', $parent)
                ->where('type', Term::TYPE_CATEGORY)
                ->where('name', $data['name'])
                ->first();
        }

        if ($term) {
            $term->update([
                'name' => $data['name'],
                'description' => $data['description'],
                'parent' => $parent
            ]);
        } else {
            $term = Term::create([
                'type' => Term::TYPE_CATEGORY,
                'name' => $data['name'],
                'description' => $data['description'],
                'parent' => $parent
            ]);
        }

        if ($term) {
            return [
                'status' => 1,
                'message' => 'Kategori oluşturuldu!',
                'data' => [
                    'newCategory' => [
                        'id' => $term->id,
                        'name' => $term->name,
                        'parent' => $term->parent ? $term->parent : 0
                    ]
                ]
            ];
        }

        return [
            'status' => 0,
            'message' => 'Kategori oluşturulurken bir hata oluştu!'
        ];
    }

    protected function getCategories()
    {
        $data = $this->request->get('data');
        $categories = Term::select('id', 'name', 'parent')
            ->where('type', Term::TYPE_CATEGORY);

        $parent = false;
        if ($data['parent'] > 0) {
            $parent = Term::find($data['parent']);
            $categories->where('parent', $data['parent']);
        } elseif ($data['parent'] == 0)
            $categories->whereNull('parent');

        $categories = $categories->get()
            ->toArray();

        if (empty($categories)) {
            return [
                'status' => 0,
                'message' => 'Alt kategoriler bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'message' => 'Alt kategoriler',
            'data' => [
                'parentCategory' => $parent,
                'categories' => $categories
            ]
        ];
    }

    protected function getSelectCategories()
    {
        $data = $this->request->all();
        $query = $data['data']['query'] ?? $this->request->get('query');

        try {
            if (isset($data['ids'])) {
                $results = $this->elasticsearch
                    ->searchSelectCategoryByIds($data['ids']);
            } else {
                $results = $this->elasticsearch
                    ->searchSelectCategory($query);
            }
        } catch (\Exception $exception) {
            return [
                'status' => 0,
                'message' => 'Kategori bulunamadı!'
            ];
        }

        $_categories = [];
        foreach ($results['hits']['hits'] as $hit) {
            $_categories[] = [
                'id' => $hit['_id'],
                'name' => $hit['_source']['name'],
                'pathName' => $hit['_source']['pathName'],
                'parent' => $hit['_source']['parent']
            ];
        }

        if (empty($_categories)) {
            return [
                'status' => 0,
                'message' => 'Kategori bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'message' => 'Kategoriler',
            'data' => [
                'categories' => $_categories
            ]
        ];
    }

    protected function getCategory()
    {
        $data = $this->request->all();

        $category = Term::find($data['data']['id']);
        if (!$category) {
            return [
                'status' => 0,
                'message' => 'Kategori bulunamadı!'
            ];
        }

        $category = $category->toArray();
        try {
            $result = $this->elasticsearch
                ->getCategoryById($category['parent']);

            $category['pathName'] = $result['_source']['pathName'];
        } catch (\Exception $exception) {
            $category['pathName'] = '';
        }

        if (!$category['parent'])
            $category['parent'] = 0;

        return [
            'status' => 1,
            'message' => $category['name'],
            'data' => [
                'category' => $category
            ]
        ];
    }

    protected function deleteCategory()
    {
        $data = $this->request->all();
        $category = Term::find($data['data']['id']);
        if (!$category) {
            return [
                'status' => 0,
                'message' => 'Bu id ile kayıtlı kategori bulunamadı!'
            ];
        }

        $subCategories = Term::where('parent', $category->id)
            ->get();
        if (!$subCategories->isEmpty()) {
            return [
                'status' => 0,
                'message' => 'Bu kategori alt kategorilere sahip. Önce alt kategorileri kaldırın!'
            ];
        }

        if ($category->delete()) {
            return [
                'status' => 1,
                'message' => 'Kategori başarıyla silindi.'
            ];
        } else {
            return [
                'status' => 0,
                'message' => 'Kategori silinirken bir hata oluştu.'
            ];
        }
    }

    protected function getSelectCategories2()
    {
        $data = $this->request->all();
        $query = $data['data']['query'];

        $categories = Term::where('type', Term::TYPE_CATEGORY)
            ->orderBy('parent');

        if (!isset($data['data']['query']) && !empty($data['data']['query']))
            $categories->where('name', 'LIKE', '%' . $query . '%');

        $categories = $categories->get();

        $_categories = [];
        foreach ($categories as $category) {
            if (!isset($category->parent))
                $category->parent = 0;

            $_categories[$category->id] = $category;
        }

        $_rcategories = [];
        $categoriesList = Term::getTermsList($categories);


        foreach ($categoriesList as $id => $pathName) {
            $_rcategories[] = [
                'id' => $id,
                'name' => $_categories[$id]->name,
                'pathName' => $pathName,
                'parent' => $_categories[$id]->parent
            ];
        }

        if (empty($_rcategories)) {
            return [
                'status' => 0,
                'message' => 'Kategori bulunamadı!'
            ];
        }

        return [
            'status' => 1,
            'data' => [
                'categories' => $_rcategories
            ]
        ];
    }
}
