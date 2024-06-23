<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddForeignKeysUserIdTable extends Migration
{
    public function up()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->addForeignKey('userId', 'user', 'id');
        $this->forge->addForeignKey('userId', 'document', 'id');
        $this->forge->addForeignKey('userId', 'tempDocument', 'id');

        $this->db->enableForeignKeyChecks();
    }

    public function down()
    {
        $this->db->disableForeignKeyChecks();

        $this->forge->dropForeignKey('document', 'document_userId_foreign');
        $this->forge->dropForeignKey('tempDocument', 'tempDocument_userId_foreign');
        $this->forge->dropForeignKey('user', 'user_userId_foreign');

        $this->db->enableForeignKeyChecks();
    }
}
