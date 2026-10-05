<?php

namespace App\Controllers;

use App\Models\ModelAkun1;
use App\Models\ModelAkun2;
use App\Models\ModelAkun3;
use CodeIgniter\HTTP\ResponseInterface;
use CodeIgniter\RESTful\ResourceController;

class Akun3 extends ResourceController
{
    protected $objAkun1;
    protected $objAkun2;
    protected $objAkun3;

    // inisialisasi object data
  public function __construct()
  {
    $this->objAkun3 = new ModelAkun3();
    $this->objAkun2 = new ModelAkun2();
    $this->db = \Config\Database::connect();
  }  

    /**
     * Return an array of resource objects, themselves in array format.
     *
     * @return ResponseInterface
     */
public function index()
{
    $builder = $this->db->table('akun3s');
    $builder->select('akun3s.*, akun1s.nama_akun1, akun2s.nama_akun2');
    $builder->join('akun1s', 'akun1s.kode_akun1 = akun3s.kode_akun1', 'left');
    $builder->join('akun2s', 'akun2s.kode_akun2 = akun3s.kode_akun2', 'left');
    $query = $builder->get();

    $data['dtakun3'] = $query->getResultArray();

    return view('akun3/index', $data);
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
        //
    }

    /**
     * Return a new resource object, with default properties.
     *
     * @return ResponseInterface
     */
    public function new()
    {
        $data['dtakun1'] = $this->db->table('akun1s')->get()->getResultArray();
        $data['dtakun2'] = $this->db->table('akun2s')->get()->getResultArray();
        $data['dtakun3'] = $this->objAkun3->findAll();
        return view('akun3/new', $data);
    }

    /**
     * Create a new resource object, from "posted" parameters.
     *
     * @return ResponseInterface
     */
    public function create()
    {
        $data = $this->request->getPost();
        $data = [
            'kode_akun3' => $this->request->getVar('kode_akun3'),
            'nama_akun3' => $this->request->getVar('nama_akun3'),
            'kode_akun2' => $this->request->getVar('kode_akun2'),
            'kode_akun1' => $this->request->getVar('kode_akun1'),
        ];
        $this->db->table('akun3s')->insert($data);
        return redirect()->to(site_url('akun3'))->with('success', 'Data berhasil disimpan');
    }

    /**
     * Return the editable properties of a resource object.
     *
     * @param int|string|null $id
     *
     * @return ResponseInterface
     */
// ... fungsi-fungsi sebelumnya (index, new, create) ...

public function edit($id = null)
{
    // 1. Ambil data akun3 yang ingin diedit
    $dtakun3 = $this->db->table('akun3s')
        ->where('id_akun3', $id)
        ->get()
        ->getRow();

    // 2. Ambil daftar akun1 dan akun2 untuk pilihan dropdown
    $dtakun1 = $this->db->table('akun1s')->get()->getResult();
    $dtakun2 = $this->db->table('akun2s')->get()->getResult();

    // 3. Kirim semua data ke view
    $data = [
        'dtakun3' => $dtakun3,
        'dtakun1' => $dtakun1, // <-- Tambahkan baris ini
        'dtakun2' => $dtakun2,
    ];

    return view('akun3/edit', $data);
}
    public function update($id = null)
    {
        $data = [
            'kode_akun1' => $this->request->getPost('kode_akun1'),
            'kode_akun2' => $this->request->getPost('kode_akun2'),
            'kode_akun3' => $this->request->getPost('kode_akun3'),
            'nama_akun3' => $this->request->getPost('nama_akun3'),
        ];

        $this->db->table('akun3s')->where('id_akun3', $id)->update($data);

        return redirect()->to(site_url('akun3'))->with('success', 'Data Berhasil Diubah');
    } // <-- Tutup fungsi update()

    public function delete($id = null)
    {
        $this->db->table('akun3s')->where('id_akun3', $id)->delete();

        return redirect()->to(site_url('akun3'))->with('success', 'Data Berhasil Dihapus');
    }

    public function destroy($id = null)
    {
        return $this->delete($id);
    }

}