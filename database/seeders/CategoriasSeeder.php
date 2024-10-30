<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CategoriasSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $categorias = [
            'Ajuste de Ternos',
            'Confecção de Camisas',
            'Reforma de Vestidos',
            'Confecção de Calças',
            'Personalização de Paletós',
            'Ajuste de Mangas',
            'Confecção de Roupas Sob Medida',
            'Ajuste de Cortinas',
            'Conserto de Peças de Alfaiataria',
            'Consultoria de Estilo'
        ];

        foreach ($categorias as $categoria) {
            DB::table('categorias')->insert([
                'categoria' => $categoria, // Insere o valor no campo 'categoria'
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
