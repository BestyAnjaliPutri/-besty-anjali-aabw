<?php

namespace App\Models;

use CodeIgniter\Model;

class ModelNilai extends Model
{
    protected $table            = 'tbl_nilai';
    protected $primaryKey       = 'id_nilai';
    // protected $useAutoIncrement = true;
    protected $returnType       = 'object';
    protected $useSoftDeletes   = false;
    protected $protectFields    = true;
    protected $allowedFields    = ['id_transaksi','kode_akun3','debit','debet','kredit','id_status'];

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

public function ambilrelasiid($id)
{
    $builder = $this->db->table('tbl_nilai')
        ->where("id_transaksi", $id)
        ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilai.kode_akun3', 'LEFT')
        ->join('tbl_status', 'tbl_status.id_status = tbl_nilai.id_status', 'LEFT');

    $query = $builder->get();
    return $query->getResultObject();
}

public function ambilJurnalUmum($tglAwal = null, $tglAkhir = null)
{
    $builder = $this->db->table('tbl_nilai')
        ->select('tbl_nilai.*, tbl_transaksi.kwitansi, tbl_transaksi.tanggal, tbl_transaksi.deskripsi, tbl_transaksi.ketjurnal, akun3s.nama_akun3')
        ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi = tbl_nilai.id_transaksi')
        ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilai.kode_akun3', 'LEFT')
        ->where('tbl_transaksi.ketjurnal !=', 'Penyesuaian');

    if (!empty($tglAwal) && !empty($tglAkhir)) {
        $builder->where('tbl_transaksi.tanggal >=', $tglAwal)
                ->where('tbl_transaksi.tanggal <=', $tglAkhir);
    }

    $builder->orderBy('tbl_transaksi.tanggal', 'ASC')
            ->orderBy('tbl_transaksi.id_transaksi', 'ASC')
            ->orderBy('tbl_nilai.debet', 'DESC');

    $query = $builder->get();
    return $query->getResultObject();
}

public function ambilPosting($kode_akun3 = null, $tglAwal = null, $tglAkhir = null)
{
    $builder = $this->db->table('tbl_nilai')
        ->select('tbl_nilai.*, tbl_transaksi.kwitansi, tbl_transaksi.tanggal, tbl_transaksi.deskripsi, tbl_transaksi.ketjurnal, akun3s.nama_akun3')
        ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi = tbl_nilai.id_transaksi')
        ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilai.kode_akun3', 'LEFT');

    if (!empty($kode_akun3)) {
        $builder->where('tbl_nilai.kode_akun3', $kode_akun3);
    }

    if (!empty($tglAwal) && !empty($tglAkhir)) {
        $builder->where('tbl_transaksi.tanggal >=', $tglAwal)
                ->where('tbl_transaksi.tanggal <=', $tglAkhir);
    }

    $builder->orderBy('tbl_nilai.kode_akun3', 'ASC')
            ->orderBy('tbl_transaksi.tanggal', 'ASC')
            ->orderBy('tbl_nilai.id_nilai', 'ASC');

    $query = $builder->get();
    return $query->getResultObject();
}

public function ambilNeracaSaldo($tglAwal = null, $tglAkhir = null)
{
    $builder = $this->db->table('tbl_nilai')
        ->select('tbl_nilai.kode_akun3, akun3s.nama_akun3, SUM(tbl_nilai.debet) as tot_debet, SUM(tbl_nilai.kredit) as tot_kredit')
        ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi = tbl_nilai.id_transaksi')
        ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilai.kode_akun3', 'LEFT')
        ->where('tbl_transaksi.ketjurnal !=', 'Penyesuaian');

    if (!empty($tglAwal) && !empty($tglAkhir)) {
        $builder->where('tbl_transaksi.tanggal >=', $tglAwal)
                ->where('tbl_transaksi.tanggal <=', $tglAkhir);
    }

    $builder->groupBy(['tbl_nilai.kode_akun3', 'akun3s.nama_akun3'])
            ->orderBy('tbl_nilai.kode_akun3', 'ASC');

    $query = $builder->get();
    return $query->getResultObject();
}

public function ambilPenyesuaian($tglAwal = null, $tglAkhir = null)
{
    $builder = $this->db->table('tbl_nilai')
        ->select('tbl_nilai.kode_akun3, akun3s.nama_akun3, SUM(tbl_nilai.debet) as tot_debet, SUM(tbl_nilai.kredit) as tot_kredit')
        ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi = tbl_nilai.id_transaksi')
        ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilai.kode_akun3', 'LEFT')
        ->where('tbl_transaksi.ketjurnal', 'Penyesuaian');

    if (!empty($tglAwal) && !empty($tglAkhir)) {
        $builder->where('tbl_transaksi.tanggal >=', $tglAwal)
                ->where('tbl_transaksi.tanggal <=', $tglAkhir);
    }

    $builder->groupBy(['tbl_nilai.kode_akun3', 'akun3s.nama_akun3'])
            ->orderBy('tbl_nilai.kode_akun3', 'ASC');

    $query = $builder->get();
    return $query->getResultObject();
}
}