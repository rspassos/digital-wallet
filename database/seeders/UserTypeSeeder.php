<?php

namespace Database\Seeders;

use App\Models\UserType;
use Illuminate\Database\Seeder;

class UserTypeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $types = [
            [
                'name' => 'Comum',
                'description' => 'Usuários comuns podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.',
                'pay' => 1,
                'receive' => 1,
            ],
            [
                'name' => 'Lojista',
                'description' => 'Usuários comuns podem enviar dinheiro (efetuar transferência) para lojistas e entre usuários.',
                'pay' => 0,
                'receive' => 1,
            ]
        ];

        UserType::insert($types);
    }
}
