<?php

namespace App\Helpers;

class System
{
    public function pageLinks(array $params = [])
    {
        $pageLinks = array_merge([
            'total' => 0,
            'per_page' => 10,
            'current_page' => 1,
            'last_page' => 1
        ], $params);

        if ($pageLinks['last_page'] <= 10) {
            // less than 10 total pages so show all
            $startPage = 1;
            $endPage = $pageLinks['last_page'];
        } else {
            // more than 10 total pages so calculate start and end pages
            if ($pageLinks['current_page'] <= 6) {
                $startPage = 1;
                $endPage = 10;
            } else if ($pageLinks['current_page'] + 4 >= $pageLinks['last_page']) {
                $startPage = $pageLinks['last_page'] - 9;
                $endPage = $pageLinks['last_page'];
            } else {
                $startPage = $pageLinks['current_page'] - 5;
                $endPage = $pageLinks['current_page'] + 4;
            }
        }

        $pageLinks['pages'] = range($startPage, $endPage);

        return $pageLinks;
    }
}
