<?php

use Illuminate\Database\Seeder;

class TeachingLanguagteTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('teaching_languages')->insert([
            'language' => 'Cantonese supplemented with English',
        ]);
        DB::table('teaching_languages')->insert([
            'language' => 'English Session',
        ]);
    }
}
