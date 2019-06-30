<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call(TemplatesTableSeeder::class);
        $this->call(ProjectsTableSeeder::class);
        $this->call(GroupsTableSeeder::class);
        $this->call(ConditionsTableSeeder::class);
    }
}
