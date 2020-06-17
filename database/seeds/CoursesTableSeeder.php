<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class CoursesTableSeeder extends Seeder
{
    private $courses = [
        '3:Русский язык:Обзорный курс по русскому языку для подготовки школьников к ОГЭ/ЕГЭ',
        '3:Литература:Обзорный курс по литературе для подготовки школьников к ОГЭ/ЕГЭ',
        '2:Математика:Обзорный курс по математике для подготовки школьников к ОГЭ/ЕГЭ',
    ];

    public function run()
    {
        foreach($this->courses as $record) {
            $fields = explode(':', $record);
            DB::table('courses')->insert([
                'user_id' => $fields[0],
                'title' => $fields[1],
                'annotation' => $fields[2],
                'description' => '',
                'contents' => '',
                'is_published' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
