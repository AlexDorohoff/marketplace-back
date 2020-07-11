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

        $i = 0;
        while ($i < 45) {
            DB::table('category')->insert([
                'id' => $i,
                'name' => 'категория 2',
                'parent_id' => null,
            ]);
            $i = $this->insertChild($i);
        }
    }

    public function insertChild($parent_id)
    {
        for ($j = 1; $j <= 5; $j++) {
            $id = $parent_id + $j;
            DB::table('category')->insert([
                'id' => $id,
                'name' => $j . ' подкатегория категории' . $parent_id,
                'parent_id' => $parent_id,
            ]);
        }
        return ++$id;
    }

    public function down()
    {
        Schema::dropIfExists('category');
    }
}
