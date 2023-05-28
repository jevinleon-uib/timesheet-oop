<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class Timesheet extends Migration
{
    public function up()
    {
        $this->forge->addField([
            't_id' => [
                'type'           => 'INT',
                'constraint'     => 11,
                'unsigned'       => true,
                'auto_increment' => true,
            ],
            'e_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false
            ],
            'd_id' => [
                'type'       => 'INT',
                'constraint' => 11,
                'null'       => false
            ],
            't_date' => [
                'type' => 'DATE',
                'null' => false,
            ],
            't_check_in' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            't_check_out' => [
                'type' => 'INT',
                'constraint' => 11,
                'null' => true,
            ],
            't_late' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            't_early' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            't_overtime' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
                'null' => true,
            ],
            't_created_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            't_updated_at' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);
        $this->forge->addKey('t_id', true);
        $this->forge->createTable('t_timesheet');
    }

    public function down()
    {
        $this->forge->dropTable('t_timesheet');
    }
}
