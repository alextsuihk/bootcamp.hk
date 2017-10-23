<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class LevelsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('levels')->insert([
            'id' => 10,
            'difficulty' => 'Secondary',
        ]);

        DB::table('levels')->insert([
            'id' => 11,
            'difficulty' => 'Non-STEM',
        ]);

        DB::table('levels')->insert([
            'id' => 21,
            'difficulty' => 'Beginner',
        ]);

        DB::table('levels')->insert([
            'id' => 22,
            'difficulty' => 'Intermediate',
        ]);

        DB::table('levels')->insert([
            'id' => 23,
            'difficulty' => 'Advanced',
        ]);
    }
}
