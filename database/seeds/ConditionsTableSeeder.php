<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class ConditionsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $name=Str::random(10);

        DB::table('conditions')->insert([
                'name'     => $name,
                'template_id'    => 1,
                'is_active' => true,
                'column_name' => 'test',
                'target_column_name' => 'test',
                'class_name' => 'test',
            ]
        );
    }
}