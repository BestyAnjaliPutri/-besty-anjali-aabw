<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelAkun3;

class Neraca extends BaseController
{
    protected $objNilai;
    protected $objAkun3;

    public function __construct()
    {
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
    }

    private function generateDataNeraca($tglAwal = null, $tglAkhir = null)
    {
        $allAkun = $this->objAkun3->orderBy('kode_akun3', 'ASC')->findAll();
        $rawNS   = $this->objNilai->ambilNeracaSaldo($tglAwal, $tglAkhir);
        $rawAJP  = $this->objNilai->ambilPenyesuaian($tglAwal, $tglAkhir);

        $mapNS = [];
        foreach ($rawNS as $r) {
            $mapNS[$r->kode_akun3] = $r;
        }

        $mapAJP = [];
        foreach ($rawAJP as $r) {
            $mapAJP[$r->kode_akun3] = $r;
        }

        $aktivaLancar = [];
        $aktivaTetap  = [];
        $kewajiban    = [];

        $totAktivaLancar = 0;
        $totAktivaTetap  = 0;
        $totKewajiban    = 0;

        $modalAwal     = 0;
        $prive         = 0;
        $totPendapatan = 0;
        $totBeban      = 0;

        foreach ($allAkun as $ak) {
            $objAk  = (object) $ak;
            $kode   = $objAk->kode_akun3;
            $nama   = $objAk->nama_akun3;
            $kepala = substr((string)$kode, 0, 1);

            $hasNS  = isset($mapNS[$kode]);
            $hasAJP = isset($mapAJP[$kode]);

            if (!$hasNS && !$hasAJP) {
                continue;
            }

            $ns_d  = $hasNS ? floatval($mapNS[$kode]->tot_debet ?? 0) : 0;
            $ns_k  = $hasNS ? floatval($mapNS[$kode]->tot_kredit ?? 0) : 0;
            $ajp_d = $hasAJP ? floatval($mapAJP[$kode]->tot_debet ?? 0) : 0;
            $ajp_k = $hasAJP ? floatval($mapAJP[$kode]->tot_kredit ?? 0) : 0;

            // Hitung saldo NSD
            if ($kode === '3101') {
                $modalAwal = ($ns_k - $ns_d) + ($ajp_k - $ajp_d);
            } elseif ($kode === '3201') {
                $prive = ($ns_d - $ns_k) + ($ajp_d - $ajp_k);
            } elseif ($kepala === '4' && $kode !== '4202') {
                $totPendapatan += ($ns_k - $ns_d) + ($ajp_k - $ajp_d);
            } elseif ($kepala === '5' || $kode === '4202') {
                $totBeban += ($ns_d - $ns_k) + ($ajp_d - $ajp_k);
            } elseif ($kepala === '1') {
                // Aktiva
                if ($kode === '1202') {
                    // Akumulasi penyusutan (kontra aset - normal kredit)
                    $saldo = ($ns_k - $ns_d) + ($ajp_k - $ajp_d);
                    $aktivaTetap[] = [
                        'kode_akun3' => $kode,
                        'nama_akun3' => $nama,
                        'saldo'      => -$saldo, // minus pengurang
                        'is_contra'  => true,
                    ];
                    $totAktivaTetap -= $saldo;
                } elseif (str_starts_with($kode, '12')) {
                    // Aktiva Tetap selain akumulasi
                    $saldo = ($ns_d - $ns_k) + ($ajp_d - $ajp_k);
                    $aktivaTetap[] = [
                        'kode_akun3' => $kode,
                        'nama_akun3' => $nama,
                        'saldo'      => $saldo,
                        'is_contra'  => false,
                    ];
                    $totAktivaTetap += $saldo;
                } else {
                    // Aktiva Lancar (1101, 1102, 1103, 1104, 1105)
                    $saldo = ($ns_d - $ns_k) + ($ajp_d - $ajp_k);
                    $aktivaLancar[] = [
                        'kode_akun3' => $kode,
                        'nama_akun3' => $nama,
                        'saldo'      => $saldo,
                    ];
                    $totAktivaLancar += $saldo;
                }
            } elseif ($kepala === '2') {
                // Kewajiban (Normal Kredit)
                $saldo = ($ns_k - $ns_d) + ($ajp_k - $ajp_d);
                $kewajiban[] = [
                    'kode_akun3' => $kode,
                    'nama_akun3' => $nama,
                    'saldo'      => $saldo,
                ];
                $totKewajiban += $saldo;
            }
        }

        $labaBersih   = $totPendapatan - $totBeban;
        $labaDitahan  = $labaBersih - $prive;
        $modalPemilik = $modalAwal;
        $totEkuitas   = $modalPemilik + $labaDitahan;
        $totAktiva    = $totAktivaLancar + $totAktivaTetap;
        $totPasiva    = $totKewajiban + $totEkuitas;

        return [
            'aktivaLancar'    => $aktivaLancar,
            'aktivaTetap'     => $aktivaTetap,
            'kewajiban'       => $kewajiban,
            'totAktivaLancar' => $totAktivaLancar,
            'totAktivaTetap'  => $totAktivaTetap,
            'totAktiva'       => $totAktiva,
            'totKewajiban'    => $totKewajiban,
            'modalPemilik'    => $modalPemilik,
            'labaDitahan'     => $labaDitahan,
            'totEkuitas'      => $totEkuitas,
            'modalAkhir'      => $totEkuitas,
            'totPasiva'       => $totPasiva,
            'tgl_awal'        => $tglAwal,
            'tgl_akhir'       => $tglAkhir,
        ];
    }

    public function index()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataNeraca($tglAwal, $tglAkhir);

        return view('neraca/index', $data);
    }

    public function neracapdf()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataNeraca($tglAwal, $tglAkhir);

        $html = view('neraca/neracapdf', $data);

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 9);
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('laporan_neraca.pdf', 'I');
        exit;
    }
}
