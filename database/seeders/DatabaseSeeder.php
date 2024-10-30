<?php

namespace Database\Seeders;


// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            CategoriasSeeder::class,
            ServicosSeeder::class,
            ClientesSeeder::class,
            //   FornecedoresSeeder::class,
            //   FluxosSeeder::class,
            //   MarcasSeeder::class,
            //   ModulosSeeder::class,
        ]);


        // \App\Models\User::factory(10)->create();

        // \App\Models\User::factory()->create([
        //     'name' => 'Test User',
        //     'email' => 'test@example.com',
        // ]);

        User::factory()->create([
            'name' => 'Sergio',
            'tipo' => 'SUPER USUARIO',
            'cpf' => '88399710334',
            'email' => 'admin@admin.com',
            'status' => 'ATIVO',
            'password' => bcrypt('210981'),
            'api_token' => Str::random(60),
        ]);
    }
}
