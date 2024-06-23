<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class EnableNullValuesDocumentTable extends Migration
{
    public function up()
    {
        // Enable null values for document table
        $this->forge->modifyColumn('document', [
            'sectorId' => [
                'type' => 'INT',
                'null' => true,
            ],
            'documentTypeId' => [
                'type' => 'INT',
                'null' => true,
            ],
            'privacy' => [
                'type' => 'VARCHAR',
                'constraint' => 50, // Adjust the length based on your ENUM values
                'null' => true,
            ],
            'shelf' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'shelfRow' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
            'shelfColumn' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => true,
            ],
        ]);

        // If using PostgreSQL, you might want to add CHECK constraints for the privacy field
        $this->db->query("
            ALTER TABLE document
            ADD CONSTRAINT check_privacy CHECK (privacy IN ('PUBLIC', 'PRIVATE', 'INTERNAL', 'CONFIDENTIAL'))
        ");
    }

    public function down()
    {
        // Revert the changes back to not allowing null values
        $this->forge->modifyColumn('document', [
            'sectorId' => [
                'type' => 'INT',
                'null' => false,
            ],
            'documentTypeId' => [
                'type' => 'INT',
                'null' => false,
            ],
            'privacy' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => false,
            ],
            'shelf' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'shelfRow' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
            'shelfColumn' => [
                'type' => 'VARCHAR',
                'constraint' => 255,
                'null' => false,
            ],
        ]);

        // Drop the CHECK constraint if it exists
        $this->db->query("
            ALTER TABLE document
            DROP CONSTRAINT IF EXISTS check_privacy
        ");
    }
}
