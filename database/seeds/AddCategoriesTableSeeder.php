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

        $i = 1;
        while ($i < 15) {
            DB::table('category')->insert([
                'name' => 'категория ' . $i,
                'parent_id' => null,
            ]);
            $this->insertChild($i);
            $i++;
        }
    }

    public function insertChild($parent_id)
    {
        for ($j = 1; $j <= 5; $j++) {
            DB::table('category')->insert([
                'name' => $j . ' подкатегория категории ' . $parent_id,
                'parent_id' => $parent_id,
            ]);
        }
    }

    public function down()
    {
        Schema::dropIfExists('category');
    }
}
