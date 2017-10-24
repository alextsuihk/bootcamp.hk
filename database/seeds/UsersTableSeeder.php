<?php

use Illuminate\Database\Seeder;
use Carbon\Carbon;

class UsersTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('users')->insert([
            'name' => 'alex',
            'nickname' => 'Alex Tsui', 
            'email' => 'alex@bootcamp.hk',
            'password' => bcrypt('password'),
            'mobile' => '96450136',
            'instructor' => true,
            'admin' => true,
            'language_id' => 1,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);

        DB::table('users')->insert([
            'name' => 'demo',
            'email' => 'demo@bootcamp.hk',
            'password' => bcrypt('password'),
            'mobile' => '12345678',
            'language_id' => 2,
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);
    }
}
