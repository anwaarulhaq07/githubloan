<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionRoleTableSeeder extends Seeder
{
    public function run()
    {
        $super_admin_permissions = Permission::all();
        $admin_permissions = $super_admin_permissions->filter(function ($permission1) {
            return substr($permission1->title, 0, 8) != 'bank_add' ;
        });
        Role::findOrFail(1)->permissions()->sync($admin_permissions->pluck('id'));
        $banker_permissions = $super_admin_permissions->filter(function ($permission2) {
            return  substr($permission2->title, 0, 5) != 'role_' && substr($permission2->title, 0, 11) != 'permission_';
        });
        Role::findOrFail(2)->permissions()->sync($banker_permissions);
        $user_permissions = $super_admin_permissions->filter(function ($permission3) {
            return $permission3->title == 'mortage_show' || $permission3->title == 'mortage_access' || $permission3->title == 'balloon_show' || $permission3->title == 'balloon_access';
        });
        Role::findOrFail(3)->permissions()->sync($user_permissions);
    }
}
