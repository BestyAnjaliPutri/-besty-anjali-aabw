<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelAkun3;

class LabaRugi extends BaseController
{
    protected $objNilai;
    protected $objAkun3;

    public function __construct()
    {
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
    }

    private function generateDataLabaRugi($tglAwal = null, $tglAkhir = null)
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

        $pendapatan    = [];
        $beban         = [];
        $totPendapatan = 0;
        $totBeban      = 0;

        foreach ($allAkun as $ak) {
            $objAk = (object) $ak;
            $kode  = $objAk->kode_akun3;
            $nama  = $objAk->nama_akun3;
            $kepala = substr((string)$kode, 0, 1);

            $hasNS  = isset($mapNS[$kode]);
            $hasAJP = isset($mapAJP[$kode]);

            if (!$hasNS && !$hasAJP) {
                continue;
            }

            // Hitung saldo disesuaikan
            $ns_d  = $hasNS ? floatval($mapNS[$kode]->tot_debet ?? 0) : 0;
            $ns_k  = $hasNS ? floatval($mapNS[$kode]->tot_kredit ?? 0) : 0;
            $ajp_d = $hasAJP ? floatval($mapAJP[$kode]->tot_debet ?? 0) : 0;
            $ajp_k = $hasAJP ? floatval($mapAJP[$kode]->tot_kredit ?? 0) : 0;

            if ($kepala === '4' && $kode !== '4202') {
                // Pendapatan (Normal Kredit)
                $saldo = ($ns_k - $ns_d) + ($ajp_k - $ajp_d);
                if ($saldo != 0) {
                    $item = (object) [
                        'kode_akun3' => $kode,
                        'nama_akun3' => $nama,
                        'jumlah'     => $saldo
                    ];
                    $pendapatan[]   = $item;
                    $totPendapatan += $saldo;
                }
            } elseif ($kepala === '5' || $kode === '4202') {
                // Beban (Normal Debit)
                $saldo = ($ns_d - $ns_k) + ($ajp_d - $ajp_k);
                if ($saldo != 0) {
                    $item = (object) [
                        'kode_akun3' => $kode,
                        'nama_akun3' => $nama,
                        'jumlah'     => $saldo
                    ];
                    $beban[]   = $item;
                    $totBeban += $saldo;
                }
            }
        }

        $labaBersih = $totPendapatan - $totBeban;

        return [
            'pendapatan'    => $pendapatan,
            'beban'         => $beban,
            'totPendapatan' => $totPendapatan,
            'totBeban'      => $totBeban,
            'labaBersih'    => $labaBersih,
            'tgl_awal'      => $tglAwal,
            'tgl_akhir'     => $tglAkhir,
        ];
    }

    public function index()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataLabaRugi($tglAwal, $tglAkhir);

        return view('labarugi/index', $data);
    }

    public function labarugipdf()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataLabaRugi($tglAwal, $tglAkhir);

        $html = view('labarugi/labarugipdf', $data);

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 9);
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('laporan_labarugi.pdf', 'I');
        exit;
    }
}
