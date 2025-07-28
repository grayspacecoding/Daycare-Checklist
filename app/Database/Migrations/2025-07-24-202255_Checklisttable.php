<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;
use CodeIgniter\Database\RawSql;

class Checklisttable extends Migration
{
    public function up()
    {
        $this->forge->addField([
            'id' => [
                'type' => 'VARCHAR',
                'constraint' => 36,
                'null' => false,
                //'default' => new RawSql('uuid()'),
            ],
            'created' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP'),
            ],
            'updated' => [
                'type' => 'TIMESTAMP',
                'null' => false,
                'default' => new RawSql('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'),
            ],
            'deleted' => [
                'type' => 'TIMESTAMP',
                'null' => true,
                'default' => null,
            ],
            'room' => [
                'type' => 'VARCHAR',
                'constraint' => 10,
                'null' => true,
            ],
            'date_applied' => [
                'type' => 'DATE',
                'null' => true,
            ],
            'status' => [
                'type' => 'VARCHAR',
                'constraint' => 15,
                'null' => false,
                'default' => 'active',
            ],
            'completed_by' => [
                'type' => 'VARCHAR',
                'constraint' => 50,
                'null' => true,
            ],
            'completed_on' => [
                'type' => 'DATETIME',
                'null' => true,
            ],
            'form_data' => [
                'type' => 'LONGTEXT',
                'null' => false
            ],
            'deleteme' => [
                'type' => 'LONGTEXT',
                'null' => false,
            ],
        ]);
        
        $this->forge->addPrimaryKey('id');
        
        // Create the table
        $this->forge->createTable('checklists');
        
        // Add custom SQL for specific MySQL features that CodeIgniter doesn't handle directly
        $this->db->query("ALTER TABLE `checklists` 
            MODIFY `id` varchar(36) NOT NULL DEFAULT (uuid()),
            MODIFY `created` timestamp NOT NULL DEFAULT current_timestamp(),
            MODIFY `updated` timestamp NOT NULL DEFAULT current_timestamp() ON UPDATE current_timestamp(),
            MODIFY `form_data` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL DEFAULT '{}',
            MODIFY `deleteme` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`deleteme`)),
            ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci");
    }

    public function down()
    {
        $this->forge->dropTable('checklists');
    }
}
