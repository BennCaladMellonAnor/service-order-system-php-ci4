<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;

class FakerUserSeeder extends Seeder
{
    public function run()
    {
        $userModel = new \App\Models\UserModel();

        $faker = \Faker\Factory::create();

        //Quantidade de registros que eu quero criar
        $size_rows = 3;

        $push_users = [];
        
        for($i = 0; $i < $size_rows; $i++){
            // array_push($push_users, [
            //     'fullname' => $faker->unique()->name,
            //     'email' => $faker->unique()->email,
            //     'password_hash' => '123456',//Alterar o fake seeder quando conhecermos hash de password
            //     'active' => true,
            // ]);
        };
        array_push($push_users, [
            'fullname' => $faker->userName(),
            'email' => $faker->unique()->email,
            'credential' => $faker->unique()->text(),
            'password_hash' => password_hash('@12345678', PASSWORD_DEFAULT),//Alterar o fake seeder quando conhecermos hash de password
            'active' => true,
        ]);
        array_push($push_users, [
            'fullname' => $faker->userName(),
            'email' => $faker->unique()->email,
            'credential' => $faker->unique()->text(),
            'password_hash' => password_hash('@12345678', PASSWORD_DEFAULT),//Alterar o fake seeder quando conhecermos hash de password
            'active' => true,
        ]);
        array_push($push_users, [
            'fullname' => $faker->userName(),
            'email' => $faker->unique()->email,
            'credential' => $faker->unique()->text(),
            'password_hash' => password_hash('@12345678', PASSWORD_DEFAULT),//Alterar o fake seeder quando conhecermos hash de password
            'active' => true,
        ]);

        //Pulanado a validação
        $userModel->skipValidation(true)
                ->protect(false) //Bypass na proteção dos campos allowedFields
                ->insertBatch($push_users);
        
        
    }
}
