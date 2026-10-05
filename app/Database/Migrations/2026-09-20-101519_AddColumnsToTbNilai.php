<?php

namespace App\Database\Migrations;

use CodeIgniter\Database\Migration;

class AddColumnsToTbNilai extends Migration
{
    public function up()
    {
        $fields = [
        'kode_akun3' => ['type' => 'VARCHAR', 'constraint' => 20, 'after' => 'id_transaksi'],
        'debet'      => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'after' => 'kode_akun3'],
        'kredit'     => ['type' => 'INT', 'constraint' => 11, 'default' => 0, 'after' => 'debet'],
        'id_status'  => ['type' => 'INT', 'constraint' => 5, 'after' => 'kredit'],
    ];
    $this->forge->addColumn('tbl_nilai', $fields);
    }

    public function down()
    {
        $this->forge->dropColumn('tbl_nilai', ['kode_akun3', 'debet', 'kredit', 'id_status']);
    }
}
