<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServicosSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $servicos = [
            [
                'categoria_id' => 1, // Exemplo: Ajuste de Ternos
                'codigo' => 'SVC001',
                'descricao' => 'Ajuste de terno completo, incluindo mangas e calças.',
                'status' => 'SIM',
                'tempo_estimado' => '10',
                'valor' => 200.00
            ],
            [
                'categoria_id' => 1,
                'codigo' => 'SVC002',
                'descricao' => 'Conserto de zíper em calças ou jaquetas.',
                'status' => 'SIM',
                'tempo_estimado' => '20',
                'valor' => 50.00
            ],
            [
                'categoria_id' => 2, // Exemplo: Confecção de Camisas
                'codigo' => 'SVC003',
                'descricao' => 'Confecção de camisa sob medida.',
                'status' => 'SIM',
                'tempo_estimado' => '30',
                'valor' => 150.00
            ],
            [
                'categoria_id' => 3, // Exemplo: Reforma de Vestidos
                'codigo' => 'SVC004',
                'descricao' => 'Reforma completa de vestidos.',
                'status' => 'SIM',
                'tempo_estimado' => '40',
                'valor' => 300.00
            ],
            [
                'categoria_id' => 4, // Exemplo: Confecção de Calças
                'codigo' => 'SVC005',
                'descricao' => 'Confecção de calça sob medida.',
                'status' => 'SIM',
                'tempo_estimado' => '30',
                'valor' => 180.00
            ],
            [
                'categoria_id' => 5, // Exemplo: Personalização de Paletós
                'codigo' => 'SVC006',
                'descricao' => 'Personalização de paletós com tecido e corte escolhido.',
                'status' => 'SIM',
                'tempo_estimado' => '5',
                'valor' => 250.00
            ],
            [
                'categoria_id' => 1,
                'codigo' => 'SVC007',
                'descricao' => 'Ajuste de mangas em camisas e blusas.',
                'status' => 'SIM',
                'tempo_estimado' => '10',
                'valor' => 60.00
            ],
            [
                'categoria_id' => 6, // Exemplo: Ajuste de Cortinas
                'codigo' => 'SVC008',
                'descricao' => 'Ajuste e confecção de cortinas personalizadas.',
                'status' => 'SIM',
                'tempo_estimado' => '22',
                'valor' => 100.00
            ],
            [
                'categoria_id' => 7, // Exemplo: Conserto de Peças de Alfaiataria
                'codigo' => 'SVC009',
                'descricao' => 'Conserto de peças de alfaiataria danificadas.',
                'status' => 'SIM',
                'tempo_estimado' => '15',
                'valor' => 80.00
            ],
            [
                'categoria_id' => 8, // Exemplo: Consultoria de Estilo
                'codigo' => 'SVC010',
                'descricao' => 'Consultoria de estilo e escolha de roupas.',
                'status' => 'SIM',
                'tempo_estimado' => '25',
                'valor' => 120.00
            ],
        ];

        foreach ($servicos as $servico) {
            DB::table('servicos')->insert([
                'categoria_id' => $servico['categoria_id'],
                'codigo' => $servico['codigo'],
                'descricao' => $servico['descricao'],
                'status' => $servico['status'],
                'tempo_estimado' => $servico['tempo_estimado'],
                'valor' => $servico['valor'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
