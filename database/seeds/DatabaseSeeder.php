<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        
        
        /*$factory*/
         factory(\App\Modules\Argaam\Models\Category::class, 50)->create();
         factory(\App\Modules\Argaam\Models\Article::class, 50)->create();

//        $this->call(SuperAdminRolePermissionAndGroup::class);
//        $this->call(SettingsSeeder::class);
    }
}
