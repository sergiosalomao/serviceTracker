<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CentroSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('centros')->insert([

            [
                'centro' => 'MATRIZ',
            ],
            [
                'centro' => 'FILIAL FORTALEZA',
            ], 

        ]);
    }
}
