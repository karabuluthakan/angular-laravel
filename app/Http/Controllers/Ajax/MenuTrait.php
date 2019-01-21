<?php
namespace App\Http\Controllers\Ajax;

use App\Menu;
use App\MenuLink;
use Illuminate\Support\Facades\Route;

trait MenuTrait
{
    protected function menuIndex()
    {
        switch ($this->request->get('job')) {
            case 'getMenuLinks':
                return $this->getMenuLinks();
                break;
        }

        return false;
    }

    protected function getMenuLinks()
    {
        $data = $this->request->get('data');
        $links = [];
        $_links = Menu::where('position', $data['position'])
            ->where('menus.status', Menu::STATUS_ACTIVE)
            ->join('menu_links', 'menu_links.menu_id', '=', 'menus.id')
            ->where('menu_links.status', MenuLink::STATUS_ACTIVE)
            ->orderBy('menu_links.parent')
            ->orderBy('menu_links.sort')
            ->get();

        foreach ($_links as $link) {
            $links[$link->id] = $link;
            if ($link->parent)
                $links[$link->parent]->has_child = true;

            if (Route::current() && Route::current()->getName() == $link->route) {
                $links[$link->id]->is_active = true;
                if ($link->parent)
                    $links[$link->parent]->is_child_active = true;
            }
        }

        unset($_links);
        return [
            'status' => 1,
            'data' => [
                'links' => array_values($links)
            ]
        ];
    }
}
