<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AppSettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //Add Default setting by test_time = 20minute, questionNo = 20
        DB::table('appsettings')->insert(['test_time'=>'1200', 'questionNo'=>'20']);
    }
}
