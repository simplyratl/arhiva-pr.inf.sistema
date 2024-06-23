<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserToDocumentTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('document', [
            'userId' => [
                'type' => 'INT',
                'null' => false,
                'after' => 'id',
                'default' => 1
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('document', 'userId');
    }
}
