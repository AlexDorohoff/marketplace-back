<?php

use Illuminate\Database\Seeder;

class CategoryTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    private $statuses = [
        '0:Литература',
        '1:Школьная программа'
    ];


    public function run()
    {
        foreach ($this->statuses as $status) {
            $fields = explode(':', $status);
            DB::table('category')->insert([
                'id' => $fields[0],
                'name' => $fields[1],
            ]);
        }
    }
}
