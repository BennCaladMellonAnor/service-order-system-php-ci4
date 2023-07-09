<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class CriaTabelaUsuarios extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 5,
                'unsigned' => true,
                'auto_increment' => true
            ],
            'fullname' => [
                'type' => 'VARCHAR',
                'constraint' => 128
            ],
            'email' => [
                'type' => 'VARCHAR',
                'constraint' => 240
            ],
            'credential' => [
                'type' => 'VARCHAR',
                'constraint' => 240
            ],
            'password_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 240
            ],
            'reset_hash' => [
                'type' => 'VARCHAR',
                'constraint' => 80,
                'null' => true,
                'default' => null
            ],
            'reset_expires' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'img' => [
                'type' => 'VARCHAR',
                'constraint' => 240,
                'null' => true,
                'default' => null
            ],
            'active' => [
                'type' => 'BOOLEAN',
                'null' => false,
            ],
            'created_in' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'updated_in' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
            'deleted_in' => [
                'type' => 'DATETIME',
                'null' => true,
                'default' => null
            ],
        ]);

        $this->forge->addKey('id', true);
        // $this->forge->addUniqueKey('email');

        $this->forge->createTable('users');
    }

    public function down()
    {
        $this->forge->dropTable('users');
    }
}
