<?php

use Illuminate\Database\Seeder;

class AddCategoriesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('category')->insert([
            'id' => 7,
            'name' => 'категория 2',
            'parent_id' => null,
        ]);

        DB::table('category')->insert([
            'id' => 8,
            'name' => '1 подкатегория категории 2',
            'parent_id' => 7,
        ]);

        DB::table('category')->insert([
            'id' => 9,
            'name' => '2 подкатегория категории 2',
            'parent_id' => 7,
        ]);

        DB::table('category')->insert([
            'id' => 10,
            'name' => '3 подкатегория категории 2',
            'parent_id' => 7,
        ]);

        DB::table('category')->insert([
            'id' => 11,
            'name' => '4 подкатегория категории 2',
            'parent_id' => 7,
        ]);

        DB::table('category')->insert([
            'id' => 12,
            'name' => 'категория 3',
            'parent_id' => null,
        ]);

        DB::table('category')->insert([
            'id' => 13,
            'name' => '1 подкатегория категории 3',
            'parent_id' => 12,
        ]);

        DB::table('category')->insert([
            'id' => 14,
            'name' => '2 подкатегория категории 3',
            'parent_id' => 12,
        ]);

        DB::table('category')->insert([
            'id' => 15,
            'name' => '3 подкатегория категории 3',
            'parent_id' => 12,
        ]);

        DB::table('category')->insert([
            'id' => 16,
            'name' => 'категория 4',
            'parent_id' => null,
        ]);

        DB::table('category')->insert([
            'id' => 17,
            'name' => '1 подкатегория категории 4',
            'parent_id' => 15,
        ]);

        DB::table('category')->insert([
            'id' => 18,
            'name' => '2 подкатегория категории 4',
            'parent_id' => 15,
        ]);

        DB::table('category')->insert([
            'id' => 19,
            'name' => '3 подкатегория категории 4',
            'parent_id' => 16,
        ]);
        DB::table('category')->insert([
            'id' => 20,
            'name' => '4 подкатегория категории 4',
            'parent_id' => 12,
        ]);

        DB::table('category')->insert([
            'id' => 21,
            'name' => 'категория 5',
            'parent_id' => null,
        ]);

        DB::table('category')->insert([
            'id' => 22,
            'name' => '1 подкатегория категории 5',
            'parent_id' => 21,
        ]);

        DB::table('category')->insert([
            'id' => 23,
            'name' => '2 подкатегория категории 5',
            'parent_id' => 21,
        ]);
    }
}
