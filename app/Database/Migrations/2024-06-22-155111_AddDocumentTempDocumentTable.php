<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDocumentTempDocumentTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('tempDocument', [
            'documentPath' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => false
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('tempDocument', 'documentPath');
    }
}
