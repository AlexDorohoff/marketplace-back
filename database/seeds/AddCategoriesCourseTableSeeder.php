<?php

use Illuminate\Database\Seeder;

class AddCategoriesCourseTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_course')->insert([
            'course_id' => 4,
            'category_id' => 2,
        ]);
        DB::table('category_course')->insert([
            'course_id' => 1,
            'category_id' => 8,
        ]);

        DB::table('category_course')->insert([
            'course_id' => 8,
            'category_id' => 5,
        ]);

        DB::table('category_course')->insert([
            'course_id' => 2,
            'category_id' => 3,
        ]);
    }
}
