<?php 

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class MovimentosSeeder extends Seeder
{
    
    
    
    public function run()
    {
        $movimentos = [];
        $tipos = ['DEBITO', 'CREDITO'];
        $status = ['ATIVO', 'INATIVO'];

        for ($i = 0; $i < 100; $i++) {
            $movimentos[] = [
                'tipo' => $tipos[array_rand($tipos)],
                'centro_id' => 1,
                'conta_id' => 1,
                'fluxo_id' => rand(1, 4),
                'descricao' => $this->getDescricao(),
                'valor' => round(rand(1000, 50000) / 100, 2), // valor entre 10.00 e 500.00
               // 'status' => $status[array_rand($status)],
               'data' => $this->getRandomDate(), 
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }

       

        DB::table('movimentos')->insert($movimentos);
    }

    private function getDescricao()
    {
        $descriptions = [
            'Conta de água',
            'Conta de luz',
            'Recebimento de cliente',
            'Depósito em conta',
            'Pagamento de fornecedor',
            'Compra de material',
            'Salário de funcionário',
            'Venda de produtos',
            'Recebimento de aluguel',
            'Despesas com internet',
            'Pagamento de imposto',
            'Fatura de cartão de crédito',
            'Pagamento de serviços',
            'Compra de equipamentos',
            'Despesas de viagem',
            'Recebimento de doação',
            'Reembolso de despesas',
            'Venda de ativos',
            'Aumento de capital',
            'Distribuição de lucros',
        ];

        return $descriptions[array_rand($descriptions)];
    }

    private function getRandomDate()
    {
        // Gera uma data aleatória nos últimos 30 dias
        return now()->subDays(rand(0, 30))->format('Y-m-d');
    }
}
