<?php

use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    private $tags = [
        "Алгебра",
        "Английский язык",
        "Астрономия",
        "Биология",
        "География",
        "Геометрия",
        "Естествознание",
        "Изобразительное искусство",
        "Информатика",
        "История",
        "Краеведение",
        "Литература",
        "Математика",
        "Мировая художественная культура",
        "Немецкий язык",
        "Обществознание",
        "Основы безопасности жизнедеятельности",
        "Основы религиозных культур и светской этики",
        "Подготовка к олимпиаде",
        "Подготовка к школе",
        "Природоведение",
        "Риторика",
        "Русский язык",
        "Технология",
        "Труд",
        "Физика",
        "Физкультура",
        "Философия",
        "Химия",
        "Черчение",
        "Чистописание",
        "Чтение",
        "Шахматы",
    ];

    public function run()
    {
        foreach($this->tags as $record) {
            DB::table('tags')->insert([
                'user_id' => 1,
                'name' => $record,
                'is_persistent' => true,
                'created_at' => Carbon::now(),
                'updated_at' => Carbon::now()
            ]);
        }
    }
}
