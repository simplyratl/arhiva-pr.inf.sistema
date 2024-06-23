<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class RenameDocumentTablesToDocumentTable extends Migration
{
    public function up()
    {
        $this->forge->renameTable('tempDocuments', 'tempDocument');
    }

    public function down()
    {
        $this->forge->renameTable('tempDocument', 'tempDocuments');
    }
}
