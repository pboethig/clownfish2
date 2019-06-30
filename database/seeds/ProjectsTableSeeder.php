<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ProjectsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('projects')->insert(
            [
                'name'     => Str::random(10),
                'user_id'    => 1,
                'groups' => '[]',
                'is_active' => true,

            ]
        );

        DB::table('projects')->insert(
            [
                'name'     => Str::random(10),
                'user_id'    => 1,
                'groups' => '[]',
                'is_active' => true,

            ]
        );
    }
}

