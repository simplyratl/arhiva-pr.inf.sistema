<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateSectorTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'null' => false,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'createdAt' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('sector');
    }

    public function down()
    {
        $this->forge->dropTable('sector');
    }
}
