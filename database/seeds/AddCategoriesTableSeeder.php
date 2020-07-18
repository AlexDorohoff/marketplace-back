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

        $counter = 1;
        $i = 1;
        while ($counter < 15) {
            DB::table('category')->insert([
                'name' => 'категория ' . $counter,
                'parent_id' => null,
            ]);
            $i = $this->insertChild($counter, $i);
            $counter++;
            $i++;
        }
    }

    public function insertChild($counter, $i)
    {
        $parent_id = $i;
        for ($j = 1; $j <= 5; $j++) {
            DB::table('category')->insert([
                'name' => $j . ' подкатегория категории ' . $counter,
                'parent_id' => $parent_id,
            ]);
            $i++;
        }
        return $i;
    }

}
