<?php

namespace App\Libraries;

use Elasticsearch\ClientBuilder;

class Elasticsearch
{
    public $client;

    public function __construct()
    {
        $this->client = ClientBuilder::create()
            ->setRetries(2)
            ->build();
    }

    public function indexSelectCategory($category)
    {
        $params = [
            'index' => 'select_categories',
            'type' => 'category',
            'id' => $category->id,
            'body' => [
                'name' => $category->name,
                'pathName' => $category->pathName,
                'parent' => $category->parent
            ]
        ];

        return $this->client
            ->index($params);
    }

    public function searchSelectCategory($query, $size = 10)
    {
        $params = [
            'index' => 'select_categories',
            'type' => 'category',
            'size' => $size,
            'body' => [
                'query' => [
                    'bool' => [
                        'should' => [
                            [
                                'multi_match' => [
                                    'query' => $query,
                                    'fields' => [
                                        'name^100', 'pathName'
                                    ]
                                ]
                            ],
                            [
                                'regexp' => [
                                    'pathName' => $query . '.*?',
                                ]
                            ],
                            [
                                'regexp' => [
                                    'pathName' => '.*?' . $query,
                                ]
                            ],
                            [
                                'regexp' => [
                                    'pathName' => '.*?' . $query . '.*?',
                                ]
                            ]
                        ],
                        "minimum_should_match" => 1
                    ]
                ]
            ]
        ];

        return $this->client
            ->search($params);
    }

    public function searchSelectCategoryByIds($ids, $size = 10)
    {
        $params = [
            'index' => 'select_categories',
            'type' => 'category',
            'size' => $size,
            'body' => [
                'query' => [
                    'ids' => [
                        'type' => '_doc',
                        'values' => '[' . implode(',', $ids) . ']'
                    ]
                ]
            ]
        ];

        return $this->client
            ->search($params);
    }

    public function getCategoryById($id)
    {
        $params = [
            'index' => 'select_categories',
            'type' => 'category',
            'id' => $id
        ];

        return $this->client
            ->get($params);
    }
}
