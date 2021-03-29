<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $root = new Role();
        $root->name = 'Root';
        $root->slug = 'root';
        $root->save();
        $user = new Role();
        $user->name = 'User';
        $user->slug = 'User';
        $user->save();
    }
}
