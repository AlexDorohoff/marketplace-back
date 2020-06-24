<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoryXTeacherUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category_user')->insert([
            'id' => 0,
            'category_id' => 1,
            'user_id' => 3,
        ]);
    }
}
