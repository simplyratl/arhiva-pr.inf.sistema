<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeyUserIdTempDocumentTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addForeignKey('userId', 'tempDocument', 'users', 'id', 'CASCADE', 'CASCADE');
        $this->forge->addForeignKey('userId', 'document', 'users', 'id', 'CASCADE', 'CASCADE');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropForeignKey('tempDocument', 'tempDocument_userId_foreign');
        $this->forge->dropForeignKey('document', 'document_userId_foreign');

        $this->db->enableForeignKeyChecks();
    }
}
