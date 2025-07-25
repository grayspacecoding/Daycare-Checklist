<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class ChecklistDropDeletemeCol extends Migration
{
    public function up()
    {
        $this->forge->dropColumn('checklists', 'deleteme');
    }

    public function down()
    {
        $this->forge->addColumn('checklists', [
            'deleteme' => [
                'type' => 'LONGTEXT',
                'null' => false,
                'after' => 'form_data'
            ]
        ]);
        
        // Add the JSON validation constraint back
        $this->db->query("ALTER TABLE `checklists` 
            MODIFY `deleteme` longtext CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NOT NULL CHECK (json_valid(`deleteme`))");
    }
}
