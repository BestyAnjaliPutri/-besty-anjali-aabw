<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelTransaksi extends Model
{
    protected $table            = 'tbl_transaksi';
    protected $primaryKey       = 'id_transaksi';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kwitansi', 'tanggal', 'deskripsi','ketjurnal'];
    // protected $DBGroup          = 'default';
    // protected $useAutoIncrement = true;
    // protected $insertID         = 0;
    // protected $useSoftDeletes   = false;
    // protected $protectFields    = true;

    protected bool $allowEmptyInserts = false;
    protected bool $updateOnlyChanged = true;

    protected array $casts = [];
    protected array $castHandlers = [];

    // Dates
    protected $useTimestamps = true;
    // protected $dateFormat    = 'datetime';
    // protected $createdField  = 'created_at';
    // protected $updatedField  = 'updated_at';
    // protected $deletedField  = 'deleted_at';

    // Validation
    
    // protected $validationRules      = [];
    // protected $validationMessages   = [];
    // protected $skipValidation       = false;
    // protected $cleanValidationRules = true;

    // Callbacks
    // protected $allowCallbacks = true;
    // protected $beforeInsert   = [];
    // protected $afterInsert    = [];
    // protected $beforeUpdate   = [];
    // protected $afterUpdate    = [];
    // protected $beforeFind     = [];
    // protected $afterFind      = [];
    // protected $beforeDelete   = [];
    // protected $afterDelete    = [];

    public function noKwitansi()
{
    $number = $this->db->table('tbl_transaksi')->select('RIGHT(tbl_transaksi.kwitansi,4) as kwitansi', FALSE)
        ->orderBy('kwitansi', 'DESC')->limit(1)->get()->getRowArray();

    if ($number == null) {
        $no = 1;
    } else {
        $no = intval($number['kwitansi']) + 1;
    }

    $nomor_kwitansi = str_pad($no, 4, "0", STR_PAD_LEFT);
    return $nomor_kwitansi;
}
}
