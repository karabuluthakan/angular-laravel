<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RolePermissionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS=0');
        $defaultPermissions = [
            'create_post',
            'edit_post',
            'delete_post',
            'create_category',
            'edit_category',
            'delete_category',
            'create_page',
            'edit_page',
            'delete_page',
            'create_menu',
            'edit_menu',
            'delete_menu',
            'create_link',
            'edit_link',
            'delete_link',
            'create_user',
            'edit_user',
            'delete_user',
            'edit_setting',
        ];
        foreach ($defaultPermissions as $perm) {
            for ($i = 1; $i <= 1; $i++) {
                $_rolePerm = new App\RolePermission;
                $_rolePerm->role_id = $i;
                $_rolePerm->name = $perm;
                $_rolePerm->can_do = 1;
                $_rolePerm->save();
            }
        }
        DB::statement('SET FOREIGN_KEY_CHECKS=1');
    }
}
