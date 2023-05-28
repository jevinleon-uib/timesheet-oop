<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class EmployeeSeeder extends Seeder
{
    public function run()
    {

        $faker = \Faker\Factory::create('id_ID');

        for ($i = 0; $i < 10; $i++) {
            $data = [
                'batch_id' => $faker->unique()->numerify('EMP####'),
                'f_name'    => $faker->firstName(),
                'm_name'    => $faker->lastName(),
                'l_name'    => $faker->lastName(),
                'department_id' => $faker->randomElement([1, 2, 3, 4, 5]),
                'address' => $faker->address(),
                'date_of_birth' => $faker->date(),
                'email' => $faker->email(),
                'gender' => $faker->randomElement(['male', 'female']),
                'marital_status' => $faker->randomElement(['TK', 'K0', 'K1', 'K2']),
                'password' => password_hash('123123', PASSWORD_BCRYPT),
                'shift' => $faker->randomElement(['N1', 'S1', 'S2', 'S3']),
                'is_admin' => '0',
                'created_at' => Time::now(),
                'updated_at' => Time::now(),
            ];
            $this->db->table('t_employees')->insert($data);
        }
        $admin = [
            'batch_id' => 'EMP0011',
            'f_name'    => 'Jevin',
            'l_name'    => 'Leon',
            'department_id' => 3,
            'address' => $faker->address(),
            'date_of_birth' => '2003-06-21',
            'email' => 'jevinleon@gmail.com',
            'gender' => 'male',
            'marital_status' => 'TK',
            'password' => password_hash('123123', PASSWORD_BCRYPT),
            'shift' => 'N1',
            'is_admin' => '1',
            'created_at' => Time::now(),
            'updated_at' => Time::now(),
        ];

        $this->db->table('t_employees')->insert($admin);

        // Simple Queries
        // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
    }
}
