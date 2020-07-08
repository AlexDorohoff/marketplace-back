<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TeacherCategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_user')->insert([
            'id' => 1,
            'category_id' => 2,
            'user_id' => 2,
        ]);
    }
}
