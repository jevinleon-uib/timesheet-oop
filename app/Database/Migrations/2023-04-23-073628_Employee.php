<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Employee extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'batch_id' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null' => false
            ],
            'f_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'm_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'l_name' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            'department_id' => [
                'type' => 'INT',
                'constraint' => 11,
            ],
            'address' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'date_of_birth' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'gender' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'marital_status' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'shift' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'is_admin' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);


        $this->forge->addKey('id', true);
        $this->forge->createTable('t_employees');
    }

    public function down()
    {
        $this->forge->dropTable('t_employees');
    }
}
