<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MainCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        factory(App\MainCategory::class, 50)->create()->each(function ($u) {
            $u->SubCategories()->save(factory(App\SubCategory::class)->make());
        });
    }
}
