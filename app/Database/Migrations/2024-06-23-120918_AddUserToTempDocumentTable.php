<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddUserToTempDocumentTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tempDocument', [
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
        $this->forge->dropColumn('tempDocument', 'userId');
    }
}
