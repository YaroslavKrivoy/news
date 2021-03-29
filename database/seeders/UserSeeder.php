<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use App\Models\User;
use Illuminate\Database\Seeder;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $rootRole = Role::where('slug','root')->first();
        $userRole = Role::where('slug', 'User')->first();
        $manageCategory = Permission::where('slug','manage-category')->first();
        $manageNews = Permission::where('slug','manage-news')->first();
        $root = new User();
        $root->name = 'Jhon Deo';
        $root->email = 'jhon@deo.com';
        $root->password = bcrypt('secret');
        $root->save();
        $root->roles()->attach($rootRole);
        $root->permissions()->attach($manageCategory);
        $root->permissions()->attach($manageNews);
        $user = new User();
        $user->name = 'Mike Thomas';
        $user->email = 'mike@thomas.com';
        $user->password = bcrypt('secret');
        $user->save();
        $user->roles()->attach($userRole);
        $user->permissions()->attach($manageNews);
    }
}
