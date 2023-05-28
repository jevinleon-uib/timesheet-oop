<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Department extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'd_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'd_name' => [
                'type'       => 'VARCHAR',
                'constraint' => '255',
                'null'       => false
            ],
            'd_batch_id' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'd_contact' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => false,
            ],
            'd_created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'd_updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('d_id', true);
        $this->forge->createTable('t_departments');
    }

    public function down()
    {
        $this->forge->dropTable('blog');
    }
}
