<?php

namespace App\Controllers;

use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;
use App\Models\ModelTransaksi;
use App\Models\ModelNilai;
use App\Models\ModelAkun3;
use App\Models\ModelStatus;

class Penyesuaian extends ResourceController
{
    protected $db;
    protected $objTransaksi;
    protected $objNilai;
    protected $objAkun3;
    protected $objStatus;

    public function __construct()
    {
        $this->db = \Config\Database::connect();
        $this->objTransaksi = new ModelTransaksi();
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
        $this->objStatus = new ModelStatus();
    }

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
    public function index()
    {
        $data['dtpenyesuaian'] = $this->objTransaksi->where(['ketjurnal' => 'Penyesuaian'])->findAll();
        return view('penyesuaian/index', $data);
    }

    /**
     * Return the properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function show($id = null)
    {
        $transaksi = $this->objTransaksi->find($id);
        $nilai     = $this->objNilai->ambilrelasiid($id);

        if (is_object($transaksi)) {
            $data = [
                'dttransaksi' => $transaksi,
                'dtnilai'     => $nilai,
            ];

            return view('penyesuaian/show', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        $data = [
            'dtakun3'  => $this->objAkun3->findAll(),
            'dtstatus' => $this->objStatus->findAll(),
        ];

        return view('penyesuaian/new', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $ketjurnal = $this->request->getVar('ketjurnal');
        if (empty($ketjurnal)) {
            $ketjurnal = 'Penyesuaian';
        }

        // 1. Siapkan data header transaksi penyesuaian
        $dataHeader = [
            'kwitansi'  => $this->objTransaksi->noKwitansi(),
            'tanggal'   => $this->request->getVar('tanggal'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'ketjurnal' => $ketjurnal,
        ];

        // 2. Simpan 1 baris ke tbl_transaksi
        $this->db->table('tbl_transaksi')->insert($dataHeader);
        $id_transaksi = $this->db->insertID();

        // 3. Tangkap data array dari tabel dinamis
        $kode_akun3 = $this->request->getVar('kode_akun3');
        $debet      = $this->request->getVar('debet') ?? $this->request->getVar('debit');
        $kredit     = $this->request->getVar('kredit');
        $id_status  = $this->request->getVar('id_status');

        // 4. Susun array detail untuk tbl_nilai
        $dataDetail = [];
        if ($kode_akun3 && is_array($kode_akun3)) {
            for ($i = 0; $i < count($kode_akun3); $i++) {
                $valDebet  = !empty($debet[$i]) ? $debet[$i] : 0;
                $valKredit = !empty($kredit[$i]) ? $kredit[$i] : 0;
                $dataDetail[] = [
                    'id_transaksi' => $id_transaksi,
                    'kode_akun3'   => $kode_akun3[$i],
                    'debet'        => $valDebet,
                    'debit'        => $valDebet,
                    'kredit'       => $valKredit,
                    'id_status'    => $id_status[$i] ?? null,
                ];
            }

            // 5. Simpan seluruh baris detail sekaligus
            $this->db->table('tbl_nilai')->insertBatch($dataDetail);
        }
        return redirect()->to(site_url('penyesuaian'))->with('success', 'Data transaksi penyesuaian berhasil disimpan');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function edit($id = null)
    {
        $transaksi = $this->objTransaksi->find($id);
        $akun3     = $this->objAkun3->findAll();
        $status    = $this->objStatus->findAll();
        $nilai     = $this->objNilai->ambilrelasiid($id);

        if ($transaksi) {
            $data = [
                'dttransaksi' => $transaksi,
                'dtakun3'     => $akun3,
                'dtstatus'    => $status,
                'dtnilai'     => $nilai
            ];

            return view('penyesuaian/edit', $data);
        } else {
            throw \CodeIgniter\Exceptions\PageNotFoundException::forPageNotFound();
        }
    }

    /**
     * Add or update a model resource, from "posted" properties.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function update($id = null)
    {
        $ketjurnal = $this->request->getVar('ketjurnal');
        if (empty($ketjurnal)) {
            $ketjurnal = 'Penyesuaian';
        }

        $data1 = [
            'tanggal'   => $this->request->getVar('tanggal'),
            'deskripsi' => $this->request->getVar('deskripsi'),
            'ketjurnal' => $ketjurnal,
        ];

        // 1. Update data header di tbl_transaksi
        $this->db->table('tbl_transaksi')->where(['id_transaksi' => $id])->update($data1);

        // 2. Tangkap input detail nilai
        $ids        = $this->request->getVar('id_nilai');
        $kode_akun3 = $this->request->getVar('kode_akun3');
        $debet      = $this->request->getVar('debet') ?? $this->request->getVar('debit');
        $kredit     = $this->request->getVar('kredit');
        $id_status  = $this->request->getVar('id_status');

        $result = [];
        if ($ids && is_array($ids)) {
            foreach ($ids as $key => $value) {
                $valDebet  = !empty($debet[$key]) ? $debet[$key] : 0;
                $valKredit = !empty($kredit[$key]) ? $kredit[$key] : 0;
                $result[] = [
                    'id_nilai'   => $ids[$key],
                    'kode_akun3' => $kode_akun3[$key],
                    'debet'      => $valDebet,
                    'debit'      => $valDebet,
                    'kredit'     => $valKredit,
                    'id_status'  => $id_status[$key] ?? null,
                ];
            }

            // 3. Update batch detail ke tbl_nilai
            $this->db->table('tbl_nilai')->updateBatch($result, 'id_nilai');
        }
        return redirect()->to(site_url('penyesuaian'))->with('success', 'Data transaksi penyesuaian berhasil diupdate');
    }

    /**
     * Delete the designated resource object from the model.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
    public function delete($id = null)
    {
        $this->db->table('tbl_nilai')->where(['id_transaksi' => $id])->delete();
        $this->objTransaksi->where(['id_transaksi' => $id])->delete();
        return redirect()->to(site_url('penyesuaian'))->with('success', 'Data transaksi penyesuaian berhasil dihapus');
    }

    public function destroy($id = null)
    {
        return $this->delete($id);
    }
}
