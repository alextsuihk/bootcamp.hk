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
            'sub_title' => 'The latest & hottest Web Frameworks in 2017',
            'abstract' => 'Hello World !! <hr> Prerequisite: HTML, PHP, Object Orentied Programming <hr> Note: Bring your own notebook, pre-install the following',
            'active' => 1,
            'level_id' => 22,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '101',
            'title' => 'Linux Basic',
            'sub_title' => 'Basic training to get you setup website and many development tools',
            'abstract' => 'to be updated',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '102',
            'title' => 'Building Your Home Server',
            'sub_title' => '(LAMP/LEMP) Apache Nginx MySQL PHP (GoogleDoc, Git, and more)',
            'abstract' => 'to be updated',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);


        DB::table('courses')->insert([
            'number' => '104',
            'title' => 'Web Development Basics',
            'sub_title' => 'html, css, twitter bootstrap',
            'abstract' => 'to be updated',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '105',
            'title' => 'Perl Programming I',
            'sub_title' => 'to be determined',
            'abstract' => 'to be updated',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '106',
            'title' => 'Face Recognition using Python & Tensorflow',
            'sub_title' => 'Technology includes: Python, OpenCV, Google Tensorflow,',
            'abstract' => 'to be updated',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '120',
            'title' => 'Overview on x86 PC & Server',
            'sub_title' => 'Overview on x86 PC & Server',
            'abstract' => 'BIOS, BMC, SIO, Server, various technology & acronym, IC Packaging, Section on server',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '122',
            'title' => 'Overview on SoC',
            'sub_title' => '',
            'abstract' => '',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '130',
            'title' => 'IOT (Internet of Things)',
            'sub_title' => 'NB-IOT, Web API',
            'abstract' => '',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => '140',
            'title' => 'Hardware Design Best Practices',
            'sub_title' => 'OrCAD, Cadence Allegro, PADS PowerPCB',
            'abstract' => 'Circuit Design, Schematic, Layout',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('courses')->insert([
            'number' => 'T10',
            'title' => 'Tear-Down: Android, Wristband, Computer',
            'sub_title' => '3-in-1 session',
            'abstract' => 'to be determined',
            'active' => 1,
            'level_id' => 21,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
