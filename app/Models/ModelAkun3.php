<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelAkun3 extends Model
{
    protected $table            = 'akun3s';
    protected $primaryKey       = 'id_akun3';
    protected $returnType       = 'object';
    protected $allowedFields    = ['kode_akun3', 'nama_akun3', 'kode_akun2', 'kode_akun1'];
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
    // protected $useTimestamps = false;
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

   public function ambilrelasi()
   {
      $builder = $this->db->table('akun3s');
      $builder->select('akun3s.*, akun2s.nama_akun2, akun1s.nama_akun1');
      $builder->join('akun2s', 'akun2s.kode_akun2 = akun3s.kode_akun2', 'left');
      $builder->join('akun1s', 'akun1s.kode_akun1 = akun3s.kode_akun1', 'left');
      $query = $builder->get();
      return $query->getResultArray();
   } 
}
    