<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class UsersTableSeeder extends Seeder
{
    private $users = [
        'admin:admin@example.com:Администратор:+79001234567',
        'teacher:teacher_1@example.com:Ворошилов Виктор Сергеевич:+79001234501',
        'teacher:teacher_2@example.com:Барышева Светлана Валентиновна:+79001234502',
        'student:student@example.com:Денежных Екатерина:+79003234500'
    ];

    public function run()
    {
        foreach($this->users as $record) {
            $fields = explode(':', $record);
            DB::table('users')->insert([
                'type' => $fields[0],
                'email' => $fields[1],
                'name' => $fields[2],
                'phone' => $fields[3],
                'password' => Hash::make('secret'),
                'is_active' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
