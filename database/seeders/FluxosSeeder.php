<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class FluxosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('fluxos')->insert([

            [
                'tipo' => 'CREDITO',
                'fluxo' =>'VENDAS'
            ],

        ]);
    }
}
