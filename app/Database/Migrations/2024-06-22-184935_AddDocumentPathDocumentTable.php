<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDocumentPathDocumentTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('document', [
            'documentPath' => [
                'type' => 'VARCHAR',
                'constraint' => 1000,
                'null' => false
            ]
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('document', 'documentPath');
    }
}
