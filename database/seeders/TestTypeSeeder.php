<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TestTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('test_types')->insert(
            [
                ['name' => 'ລດຈັກ'],
                ['name' => 'ລດເບົາ'],
                ['name' => 'ລົດບັນທຸກ C, ລົດໂດຍສານ D']
            ]
        );
    }
}
