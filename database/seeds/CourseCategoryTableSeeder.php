<?php

use Illuminate\Database\Seeder;

class CourseCategoryTableSeeder extends Seeder
{
    public function run()
    {
        DB::table('category_course')->insert([
            'id' => 2,
            'course_id' => 3,
            'category_id' => 4,
        ]);
    }
}
