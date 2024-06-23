<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class DeleteAppUserTable extends Migration
{
    public function up()
    {
        $this->forge->dropTable('appUser');
    }

    public function down()
    {
        $this->forge->createTable('appUser');
    }
}
