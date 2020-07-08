<?php

use Illuminate\Database\Seeder;

class UpdateCategoryTableSeeder extends Seeder
{
    private $statuses = [
        '1:Литература',
        '1:Школьная программа'
    ];


    public function run()
    {
        DB::table('category')->insert([
            'id' => 2,
            'name' => 'одежда',
            'parent_id' => null,
        ]);

        DB::table('category')->insert([
            'id' => 3,
            'name' => 'Детская деовчки',
            'parent_id' => 2,
        ]);

        DB::table('category')->insert([
            'id' => 4,
            'name' => 'Детская мальчики',
            'parent_id' => 2,
        ]);

        DB::table('category')->insert([
            'id' => 5,
            'name' => 'Женская',
            'parent_id' => 2,
        ]);

        DB::table('category')->insert([
            'id' => 6,
            'name' => 'Мужская',
            'parent_id' => 2,
        ]);
    }
}
