<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class GroupsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name=Str::random(10);

        DB::table('groups')->insert(
            [
                'name'     => $name,
                'key'    => strtoupper($name),
                'is_active' => true,
            ]
        );

        $name=Str::random(10);

        DB::table('groups')->insert(
            [
                'name'     => $name,
                'key'    => strtoupper($name),
                'is_active' => true,
            ]
        );
    }
}
