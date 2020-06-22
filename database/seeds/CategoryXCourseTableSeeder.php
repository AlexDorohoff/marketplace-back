<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryXCourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_x_course')->insert([
            'id' => 0,
            'course_id' => 4,
            'category_id' => 1,
        ]);
        DB::table('category_x_course')->insert([
            'id' => 1,
            'course_id' => 1,
            'category_id' => 1,
        ]);
    }
}
