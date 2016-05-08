<?php

use Illuminate\Database\Seeder;

use Carbon\Carbon;

class OAuthClientSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
		DB::table('oauth_clients')->delete();
        
        DB::table('oauth_clients')->insert([
            'id' => 'appid1',
            'name' => 'AngularAPP',
            'secret' => 'secret',
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ]);    	
    }
}
