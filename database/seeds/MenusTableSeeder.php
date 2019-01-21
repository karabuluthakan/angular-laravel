<?php

use Illuminate\Database\Seeder;

class MenusTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        \App\Menu::create([
            'position' => 'admin_leftsidebar_menu',
            'name' => 'Admin Menü'
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'dashboard',
            'label' => 'Dashboard',
            'icon' => 'flaticon-dashboard',
            'perm' => true,
            'sort' => 0
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_SEPARATOR,
            'label' => 'İçerik',
            'perm' => true,
            'sort' => 10
        ]);

        $postsLink = \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'javascript:;',
            'label' => 'Yazılar',
            'icon' => 'flaticon-notes',
            'perm' => 'create_post || edit_post',
            'sort' => 11
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'posts.index',
            'label' => 'Yazılar',
            'parent' => $postsLink->id,
            'perm' => 'create_post || edit_post',
            'sort' => 12
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'posts.create',
            'label' => 'Yazı Ekle',
            'parent' => $postsLink->id,
            'perm' => 'create_post',
            'sort' => 13
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'categories.index',
            'label' => 'Kategoriler',
            'parent' => $postsLink->id,
            'perm' => 'create_category || edit_category',
            'sort' => 14
        ]);

        $pagesLink = \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'javascript:;',
            'label' => 'Sayfalar',
            'icon' => 'flaticon-file',
            'perm' => 'create_page || edit_page',
            'sort' => 20
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'pages.index',
            'label' => 'Sayfalar',
            'parent' => $pagesLink->id,
            'perm' => 'create_page || edit_page',
            'sort' => 21
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'pages.create',
            'label' => 'Sayfa Ekle',
            'parent' => $pagesLink->id,
            'perm' => 'create_page',
            'sort' => 22
        ]);

        $menusLink = \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'javascript:;',
            'label' => 'Menüler',
            'icon' => 'flaticon-menu-button',
            'perm' => 'create_menu || edit_menu || create_link || edit_link',
            'sort' => 30
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'menus.index',
            'label' => 'Menüler',
            'parent' => $menusLink->id,
            'perm' => 'create_menu || edit_menu',
            'sort' => 31
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'links',
            'label' => 'Linkler',
            'parent' => $menusLink->id,
            'perm' => 'create_link || edit_link',
            'sort' => 32
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_SEPARATOR,
            'label' => 'Hesap',
            'perm' => true,
            'sort' => 40
        ]);

        $usersLink = \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'javascript:;',
            'label' => 'Kullanıcılar',
            'icon' => 'flaticon-users',
            'perm' => 'create_user || edit_user',
            'sort' => 41
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'users.index',
            'label' => 'Kullanıcılar',
            'parent' => $usersLink->id,
            'perm' => 'create_user || edit_user',
            'sort' => 42
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'users.create',
            'label' => 'Kullanıcı Ekle',
            'parent' => $usersLink->id,
            'perm' => 'create_user',
            'sort' => 43
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'roles.index',
            'label' => 'Roller',
            'parent' => $usersLink->id,
            'perm' => 'create_role || edit_role',
            'sort' => 44
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_SEPARATOR,
            'label' => 'Yönetim',
            'perm' => true,
            'sort' => 50
        ]);

        $settingsLink = \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'javascript:;',
            'label' => 'Ayarlar',
            'icon' => 'flaticon-cogwheel-2',
            'perm' => 'edit_setting',
            'sort' => 51
        ]);

        \App\MenuLink::create([
            'menu_id' => 1,
            'type' => \App\MenuLink::TYPE_LINK,
            'route' => 'settings.index',
            'label' => 'Ayarlar',
            'parent' => $settingsLink->id,
            'perm' => 'edit_setting',
            'sort' => 52
        ]);
    }
}
