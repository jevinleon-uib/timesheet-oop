<?php

namespace App\Database\Seeds;

use CodeIgniter\Database\Seeder;
use CodeIgniter\I18n\Time;

class DepartmentSeeder extends Seeder
{
    public function run()
    {
        $data = [
            [
                'd_name' => 'HR',
                'd_batch_id'    => 'DPT0001',
                'd_contact' => '081212121213',
                'd_created_at' => Time::now(),
                'd_updated_at' => Time::now(),
            ],
            [
                'd_name' => 'Planner',
                'd_batch_id'    => 'DPT0002',
                'd_contact' => '081414141414',
                'd_created_at' => Time::now(),
                'd_updated_at' => Time::now(),
            ],
            [
                'd_name' => 'Logistic',
                'd_batch_id'    => 'DPT0003',
                'd_contact' => '081515151515',
                'd_created_at' => Time::now(),
                'd_updated_at' => Time::now(),
            ],
            [
                'd_name' => 'Production',
                'd_batch_id'    => 'DPT0004',
                'd_contact' => '081616161616',
                'd_created_at' => Time::now(),
                'd_updated_at' => Time::now(),
            ],
            [
                'd_name' => 'Security',
                'd_batch_id'    => 'DPT0005',
                'd_contact' => '081717171717',
                'd_created_at' => Time::now(),
                'd_updated_at' => Time::now(),
            ],
        ];


        $this->db->table('t_departments')->insertBatch($data);

        // Simple Queries
        // $this->db->query('INSERT INTO users (username, email) VALUES(:username:, :email:)', $data);

        // Using Query Builder
    }
}
