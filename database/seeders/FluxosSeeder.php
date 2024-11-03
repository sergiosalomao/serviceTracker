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
                'fluxo' =>'SERVIÇOS'
            ],
            [
                'tipo' => 'DEBITO',
                'fluxo' =>'ENERGIA'
            ], [
                'tipo' => 'DEBITO',
                'fluxo' =>'AGUA'
            ],
            [
                'tipo' => 'DEBITO',
                'fluxo' =>'PROVEDORES DE INTERNET'
            ],
            [
                'tipo' => 'DEBITO',
                'fluxo' =>'GASOLINA'
            ],
            [
                'tipo' => 'DEBITO',
                'fluxo' =>'PAGAMENTO SALARIO FUNCIONARIOS'
            ],

        ]);
    }
}
