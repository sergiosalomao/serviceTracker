<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ClientesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $clientes = [
            [
                'nome' => 'João Silva',
                'telefone' => '88986994714',
                'nascimento' => '15/05/1985',
                'email' => 'joao.silva@email.com',
                'cep' => '12345-678',
                'rua' => 'Rua A',
                'numero' => '123',
                'complemento' => 'Apto 101',
                'bairro' => 'Centro',
                'cidade' => 'São Paulo',
                'uf' => 'SP',
                'cpf_cnpj' => '123.456.789-00',
                'obs' => 'Cliente fiel',
                'tipo_cliente' => 'regular'
            ],
            [
                'nome' => 'Maria Oliveira',
                'telefone' => '88912345678',
                'nascimento' => '20/10/1990',
                'email' => 'maria.oliveira@email.com',
                'cep' => '23456-789',
                'rua' => 'Rua B',
                'numero' => '456',
                'complemento' => 'Casa',
                'bairro' => 'Jardim',
                'cidade' => 'Rio de Janeiro',
                'uf' => 'RJ',
                'cpf_cnpj' => '987.654.321-00',
                'obs' => 'Preferência por contato por e-mail',
                'tipo_cliente' => 'vip'
            ],
            [
                'nome' => 'Carlos Pereira',
                'telefone' => '88965432123',
                'nascimento' => '30/03/1978',
                'email' => 'carlos.pereira@email.com',
                'cep' => '34567-890',
                'rua' => 'Rua C',
                'numero' => '789',
                'complemento' => 'Bloco 2',
                'bairro' => 'Bela Vista',
                'cidade' => 'Belo Horizonte',
                'uf' => 'MG',
                'cpf_cnpj' => '654.321.987-00',
                'obs' => 'Necessita de atendimento especial',
                'tipo_cliente' => 'especial'
            ],
            [
                'nome' => 'Ana Costa',
                'telefone' => '88976543210',
                'nascimento' => '14/02/1995',
                'email' => 'ana.costa@email.com',
                'cep' => '45678-901',
                'rua' => 'Rua D',
                'numero' => '101',
                'complemento' => 'Casa',
                'bairro' => 'São Bento',
                'cidade' => 'Curitiba',
                'uf' => 'PR',
                'cpf_cnpj' => '789.012.345-00',
                'obs' => 'Interesse em novos produtos',
                'tipo_cliente' => 'regular'
            ],
            [
                'nome' => 'Roberto Almeida',
                'telefone' => '88965432198',
                'nascimento' => '05/08/1982',
                'email' => 'roberto.almeida@email.com',
                'cep' => '56789-012',
                'rua' => 'Rua E',
                'numero' => '202',
                'complemento' => 'Apto 202',
                'bairro' => 'Pinheiros',
                'cidade' => 'São Paulo',
                'uf' => 'SP',
                'cpf_cnpj' => '321.654.987-00',
                'obs' => 'Cliente preferencial',
                'tipo_cliente' => 'vip'
            ],
            // Adicione mais clientes conforme necessário
        ];

        // Gerar mais clientes para totalizar 30
        for ($i = 1; $i <= 100; $i++) {
            $clientes[] = [
                'nome' => "Cliente $i",
                'telefone' => "8890000000" . ($i % 10), // Telefone no padrão solicitado
                'nascimento' => sprintf("%02d/%02d/%04d", rand(1, 28), rand(1, 12), rand(1970, 2000)), // Data aleatória
                'email' => "cliente{$i}@email.com",
                'cep' => str_pad(rand(10000, 99999), 5, '0', STR_PAD_LEFT) . '-' . str_pad(rand(0, 9), 3, '0', STR_PAD_LEFT),
                'rua' => "Rua " . chr(65 + rand(0, 25)), // Rua aleatória A-Z
                'numero' => (string)rand(1, 100),
                'complemento' => 'Apto ' . rand(1, 300),
                'bairro' => 'Bairro ' . chr(65 + rand(0, 25)),
                'cidade' => 'Cidade ' . chr(65 + rand(0, 25)),
                'uf' => 'SP',
                'cpf_cnpj' => str_pad(rand(10000000000, 99999999999), 11, '0', STR_PAD_LEFT),
                'obs' => 'Observação ' . $i,
                'tipo_cliente' => (rand(0, 1) == 0) ? 'regular' : 'vip',
            ];
        }

        foreach ($clientes as $cliente) {
            DB::table('clientes')->insert([
                'nome' => $cliente['nome'],
                'telefone' => $cliente['telefone'],
                'nascimento' => $cliente['nascimento'],
                'email' => $cliente['email'],
                'cep' => $cliente['cep'],
                'rua' => $cliente['rua'],
                'numero' => $cliente['numero'],
                'complemento' => $cliente['complemento'],
                'bairro' => $cliente['bairro'],
                'cidade' => $cliente['cidade'],
                'uf' => $cliente['uf'],
                'cpf_cnpj' => $cliente['cpf_cnpj'],
                'obs' => $cliente['obs'],
                'tipo_cliente' => $cliente['tipo_cliente'],
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }
    }
}
