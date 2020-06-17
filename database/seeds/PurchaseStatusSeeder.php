<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PurchaseStatusSeeder extends Seeder
{
    private $statuses = [
        '0:Заявка',
        '1:Реализация'
    ];

    public function run()
    {
        foreach ($this->statuses as $status) {
            $fields = explode(':', $status);
            DB::table('purchase_statuses')->insert([
                'id' => $fields[0],
                'label' => $fields[1],
            ]);
        }
    }
}
