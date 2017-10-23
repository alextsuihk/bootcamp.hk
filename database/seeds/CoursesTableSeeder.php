<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class CoursesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('courses')->insert([
            'number' => '303',
            'title' => 'Laravel 5.5 Introduction',
            'abstract' => 'to be updated',
            'is_active' => 1,
            'level_id' => 22,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '101',
            'title' => 'Linux Basic',
            'abstract' => 'to be updated',
            'is_active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '102',
            'title' => 'Apache Nginx MySQL PHP',
            'abstract' => 'to be updated',
            'is_active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        DB::table('courses')->insert([
            'number' => '104',
            'title' => 'Web Development',
            'abstract' => 'to be updated',
            'is_active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '105',
            'title' => 'Perl Programming I',
            'abstract' => 'to be updated',
            'is_active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '106',
            'title' => 'Python Programming I',
            'abstract' => 'to be updated',
            'is_active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '120',
            'title' => 'Hardware Design Best Practices',
            'abstract' => 'Circuit Design, Schematic, Layout',
            'is_active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

    }
}
