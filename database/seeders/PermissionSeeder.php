<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $manageCategory = new Permission();
        $manageCategory->name = 'Manage category';
        $manageCategory->slug = 'manage-category';
        $manageCategory->save();
        $manageNews = new Permission();
        $manageNews->name = 'Manage news';
        $manageNews->slug = 'manage-news';
        $manageNews->save();
    }
}
