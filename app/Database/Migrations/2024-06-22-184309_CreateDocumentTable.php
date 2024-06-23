<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateDocumentTable extends Migration
{
    public function up()
    {
        $this->db->query("
            CREATE TYPE privacy_enum AS ENUM ('PUBLIC', 'PRIVATE', 'INTERNAL', 'CONFIDENTIAL')
        ");

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
            'shelf' => [
                'type' => 'INT',
            ],
            'shelfRow' => [
                'type' => 'INT',
            ],
            'shelfColumn' => [
                'type' => 'INT',
            ],
            'sectorId' => [
                'type' => 'INT',
            ],
            'privacy' => [
                'type' => 'privacy_enum',
                'default' => 'PRIVATE',
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
        $this->forge->addForeignKey('sectorId', 'sector', 'id', 'CASCADE', 'CASCADE');
        $this->forge->createTable('document');
    }

    public function down()
    {
        $this->forge->dropTable('document');
    }
}
