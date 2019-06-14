<?php

use Illuminate\Database\Seeder;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;

class TemplatesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {

        for ($i = 0; $i < 10000; $i++) {



        DB::table('templates')->insert(
            [
                'name'     => Str::random(10),
                'user_id'    => 1,
                'project_id' => 1,
                'groups' => '[]',
                'file_path' => '/file/path/test.xlsx',
                'file_type' => 'xslx',
                'is_active' => true,
                'import_table' => 'import_table',
                'export_table' => 'export_table',
                'adapter_class' => 'adapter_class',
            ]
        );
        }
    }
}