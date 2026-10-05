<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelAkun3;

class PerubahanModal extends BaseController
{
    protected $objNilai;
    protected $objAkun3;

    public function __construct()
    {
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
    }

    private function generateDataPerubahanModal($tglAwal = null, $tglAkhir = null)
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

        $modalAwal     = 0;
        $prive         = 0;
        $totPendapatan = 0;
        $totBeban      = 0;

        foreach ($allAkun as $ak) {
            $objAk = (object) $ak;
            $kode  = $objAk->kode_akun3;
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

            if ($kode === '3101') {
                // Modal Pemilik (Normal Kredit)
                $modalAwal = ($ns_k - $ns_d) + ($ajp_k - $ajp_d);
            } elseif ($kode === '3201') {
                // Prive Pemilik (Normal Debit)
                $prive = ($ns_d - $ns_k) + ($ajp_d - $ajp_k);
            } elseif ($kepala === '4' && $kode !== '4202') {
                // Pendapatan (Normal Kredit)
                $totPendapatan += ($ns_k - $ns_d) + ($ajp_k - $ajp_d);
            } elseif ($kepala === '5' || $kode === '4202') {
                // Beban (Normal Debit)
                $totBeban += ($ns_d - $ns_k) + ($ajp_d - $ajp_k);
            }
        }

        $labaBersih    = $totPendapatan - $totBeban;
        $perubahanNet  = $labaBersih - $prive;
        $modalAkhir    = $modalAwal + $perubahanNet;

        return [
            'modalAwal'    => $modalAwal,
            'labaBersih'   => $labaBersih,
            'prive'        => $prive,
            'perubahanNet' => $perubahanNet,
            'modalAkhir'   => $modalAkhir,
            'tgl_awal'     => $tglAwal,
            'tgl_akhir'    => $tglAkhir,
        ];
    }

    public function index()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataPerubahanModal($tglAwal, $tglAkhir);

        return view('perubahanmodal/index', $data);
    }

    public function perubahanmodalpdf()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataPerubahanModal($tglAwal, $tglAkhir);

        $html = view('perubahanmodal/perubahanmodalpdf', $data);

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 9);
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('laporan_perubahanmodal.pdf', 'I');
        exit;
    }
}
