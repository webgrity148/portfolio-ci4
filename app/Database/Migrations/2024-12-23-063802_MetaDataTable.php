<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class MetaDataTable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'INT',
                'constraint' => 11,
                'unsigned' => true,
                'auto_increment' => true,
            ],
            'key' => [
                'type' => 'VARCHAR',
                'constraint' => '255',
            ],
            'value' => [
                'type' => 'TEXT',
            ],
            'created_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'onUpdate' => 'CURRENT_TIMESTAMP',
            ],
            'updated_at' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'onUpdate' => 'CURRENT_TIMESTAMP',
            ]
        ]);
        $this->forge->addKey('id', true);
        $this->forge->createTable('meta_data');
    }

    public function down()
    {
        $this->forge->dropTable('meta_data');
    }
}
