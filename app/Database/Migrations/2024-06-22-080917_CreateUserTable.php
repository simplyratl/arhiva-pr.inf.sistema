<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CreateUserTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'null' => false,
                'auto_increment' => true,
            ],
            'name' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'firstName' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'lastName' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'password' => [
                'type' => 'VARCHAR',
                'constraint' => '100',
                'null' => false,
            ],
            'role' => [
                'type' => 'VARCHAR',
                'null' => false,
            ],
            'createdAt' => [
                'type' => 'DATETIME',
                'null' => false,
            ],
        ]);

        $this->forge->addPrimaryKey('id');
        $this->forge->createTable('appUser');
    }

    public function down()
    {
        $this->forge->dropTable('appUser');
    }
}
