<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grades = ['1年', '2年', '3年', '4年', '5年', '6年'];
        $subjects = ['国語', '算数', '理科', '社会', '音楽', '図工', '体育', '家庭科', '総合', '道徳', '学級活動'];

        foreach($grades as $grade) {
            DB::table('tags')->insert([
                'name' => $grade,
            ]);
        }

        foreach($subjects as $subject) {
            DB::table('tags')->insert([
                'name' => $subject,
            ]);
        }
    }
}
