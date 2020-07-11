<?php

use Illuminate\Database\Seeder;

class AddCategoriesUserTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_user')->insert([
            'category_id' => 1,
            'user_id' => 2,
        ]);

        DB::table('category_user')->insert([
            'category_id' => 7,
            'user_id' => 2,
        ]);
    }
}
