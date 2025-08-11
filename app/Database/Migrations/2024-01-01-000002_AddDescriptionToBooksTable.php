<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddDescriptionToBooksTable extends Migration
{
    public function up()
    {
        $this->forge->addColumn('books', [
            'description' => [
                'type' => 'TEXT',
                'null' => true,
                'after' => 'publication_year',
            ],
        ]);
    }

    public function down()
    {
        $this->forge->dropColumn('books', 'description');
    }
}
