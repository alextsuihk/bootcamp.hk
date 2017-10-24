<?php

use Illuminate\Database\Seeder;

class LanguagesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('languages')->insert([
            'language' => 'en',
        ]);
        DB::table('languages')->insert([
            'language' => 'zh-Hant',
        ]);
        DB::table('languages')->insert([
            'language' => 'zh-Hans',
        ]);

    }
}
