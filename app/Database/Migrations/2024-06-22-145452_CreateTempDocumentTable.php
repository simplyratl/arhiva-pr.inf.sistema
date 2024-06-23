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
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => 100,
            ],
            'boxNumber' => [
                'type' => 'INT',
                'constraint' => 100,
            ],
            'registerNumber' => [
                'type' => 'INT',
                'constraint' => 100,
            ],
            'documentTypeId' => [
                'type' => 'INT',
            ],
            'createdAt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'updatedAt' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->addForeignKey('documentTypeId', 'documentType', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('tempDocuments');
    }

    public function down()
    {
        $this->forge->dropTable('tempDocuments');
    }
}
