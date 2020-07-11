<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryCourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_course')->insert([
            'course_id' => 3,
            'category_id' => 1,
        ]);
        DB::table('category_course')->insert([
            'course_id' => 1,
            'category_id' => 1,
        ]);
    }
}
