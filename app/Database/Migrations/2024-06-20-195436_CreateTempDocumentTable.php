<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateTempDocumentTable extends Migration
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
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('temp_document');
    }

    public function down()
    {
        $this->forge->dropTable('temp_document');
    }
}
