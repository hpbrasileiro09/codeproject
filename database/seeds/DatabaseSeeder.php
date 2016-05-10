<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0'); // disable foreign key constraints

        DB::table('project_files')->truncate();

        \CodeProject\Entities\ProjectMember::truncate();
        \CodeProject\Entities\ProjectTask::truncate();
        \CodeProject\Entities\ProjectNote::truncate();
        \CodeProject\Entities\Project::truncate();
        \CodeProject\Entities\Client::truncate();
        \CodeProject\Entities\User::truncate();

        DB::statement('SET FOREIGN_KEY_CHECKS = 1'); // enable foreign key constraints

        $this->call(UserTableSeeder::class);
        $this->call(ClientTableSeeder::class);
        $this->call(ProjectTableSeeder::class);
        $this->call(ProjectNoteTableSeeder::class);
        $this->call(ProjectMemberTableSeeder::class);
        $this->call(ProjectTaskTableSeeder::class);
        $this->call(OAuthClientSeeder::class);
    }
}
