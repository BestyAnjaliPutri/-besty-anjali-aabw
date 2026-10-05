<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelAkun3;

class NeracaLajur extends BaseController
{
    protected $objNilai;
    protected $objAkun3;

    public function __construct()
    {
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
    }

    private function generateDataNeracaLajur($tglAwal = null, $tglAkhir = null)
    {
        $allAkun = $this->objAkun3->orderBy('kode_akun3', 'ASC')->findAll();
        $rawNS   = $this->objNilai->ambilNeracaSaldo($tglAwal, $tglAkhir);
        $rawAJP  = $this->objNilai->ambilPenyesuaian($tglAwal, $tglAkhir);

        // Map NS by kode_akun3
        $mapNS = [];
        foreach ($rawNS as $r) {
            $mapNS[$r->kode_akun3] = $r;
        }

        // Map AJP by kode_akun3
        $mapAJP = [];
        foreach ($rawAJP as $r) {
            $mapAJP[$r->kode_akun3] = $r;
        }

        $dtlajur        = [];
        $tot_ns_debet   = 0;
        $tot_ns_kredit  = 0;
        $tot_ajp_debet  = 0;
        $tot_ajp_kredit = 0;
        $tot_nsd_debet  = 0;
        $tot_nsd_kredit = 0;
        $tot_lr_debet   = 0;
        $tot_lr_kredit  = 0;
        $tot_n_debet    = 0;
        $tot_n_kredit   = 0;

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

            // 1. Neraca Saldo (NS)
            $ns_d_raw = $hasNS ? floatval($mapNS[$kode]->tot_debet ?? 0) : 0;
            $ns_k_raw = $hasNS ? floatval($mapNS[$kode]->tot_kredit ?? 0) : 0;

            $isNormalDebet = ($kode === '3201' || $kode === '4202' || in_array($kepala, ['1', '5']));
            if ($kode === '1202') {
                $isNormalDebet = false; // Akumulasi penyusutan normal kredit (kontra aset)
            }

            if ($isNormalDebet) {
                $saldoNS = $ns_d_raw - $ns_k_raw;
                $ns_debet  = ($saldoNS >= 0) ? $saldoNS : 0;
                $ns_kredit = ($saldoNS < 0) ? abs($saldoNS) : 0;
            } else {
                $saldoNS = $ns_k_raw - $ns_d_raw;
                $ns_kredit = ($saldoNS >= 0) ? $saldoNS : 0;
                $ns_debet  = ($saldoNS < 0) ? abs($saldoNS) : 0;
            }

            // 2. Ayat Jurnal Penyesuaian (AJP)
            $ajp_debet  = $hasAJP ? floatval($mapAJP[$kode]->tot_debet ?? 0) : 0;
            $ajp_kredit = $hasAJP ? floatval($mapAJP[$kode]->tot_kredit ?? 0) : 0;

            // 3. Neraca Saldo Disesuaikan (NSD)
            if ($isNormalDebet) {
                $saldoNSD = ($ns_debet - $ns_kredit) + ($ajp_debet - $ajp_kredit);
                $nsd_debet  = ($saldoNSD >= 0) ? $saldoNSD : 0;
                $nsd_kredit = ($saldoNSD < 0) ? abs($saldoNSD) : 0;
            } else {
                $saldoNSD = ($ns_kredit - $ns_debet) + ($ajp_kredit - $ajp_debet);
                $nsd_kredit = ($saldoNSD >= 0) ? $saldoNSD : 0;
                $nsd_debet  = ($saldoNSD < 0) ? abs($saldoNSD) : 0;
            }

            // 4. Laba Rugi (LR) vs 5. Neraca (N)
            $lr_debet  = 0;
            $lr_kredit = 0;
            $n_debet   = 0;
            $n_kredit  = 0;

            if ($kepala === '4' || $kepala === '5') {
                $lr_debet  = $nsd_debet;
                $lr_kredit = $nsd_kredit;
            } else {
                $n_debet  = $nsd_debet;
                $n_kredit = $nsd_kredit;
            }

            $rowObj = (object) [
                'kode_akun3'  => $kode,
                'nama_akun3'  => $nama,
                'ns_debet'    => $ns_debet,
                'ns_kredit'   => $ns_kredit,
                'ajp_debet'   => $ajp_debet,
                'ajp_kredit'  => $ajp_kredit,
                'nsd_debet'   => $nsd_debet,
                'nsd_kredit'  => $nsd_kredit,
                'lr_debet'    => $lr_debet,
                'lr_kredit'   => $lr_kredit,
                'n_debet'     => $n_debet,
                'n_kredit'    => $n_kredit,
            ];

            $dtlajur[] = $rowObj;

            $tot_ns_debet   += $ns_debet;
            $tot_ns_kredit  += $ns_kredit;
            $tot_ajp_debet  += $ajp_debet;
            $tot_ajp_kredit += $ajp_kredit;
            $tot_nsd_debet  += $nsd_debet;
            $tot_nsd_kredit += $nsd_kredit;
            $tot_lr_debet   += $lr_debet;
            $tot_lr_kredit  += $lr_kredit;
            $tot_n_debet    += $n_debet;
            $tot_n_kredit   += $n_kredit;
        }

        $laba_bersih = $tot_lr_kredit - $tot_lr_debet;

        return [
            'dtlajur'        => $dtlajur,
            'tot_ns_debet'   => $tot_ns_debet,
            'tot_ns_kredit'  => $tot_ns_kredit,
            'tot_ajp_debet'  => $tot_ajp_debet,
            'tot_ajp_kredit' => $tot_ajp_kredit,
            'tot_nsd_debet'  => $tot_nsd_debet,
            'tot_nsd_kredit' => $tot_nsd_kredit,
            'tot_lr_debet'   => $tot_lr_debet,
            'tot_lr_kredit'  => $tot_lr_kredit,
            'tot_n_debet'    => $tot_n_debet,
            'tot_n_kredit'   => $tot_n_kredit,
            'laba_bersih'    => $laba_bersih,
            'tgl_awal'       => $tglAwal,
            'tgl_akhir'      => $tglAkhir,
        ];
    }

    public function index()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataNeracaLajur($tglAwal, $tglAkhir);

        return view('neracalajur/index', $data);
    }

    public function neracalajurpdf()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataNeracaLajur($tglAwal, $tglAkhir);

        $html = view('neracalajur/neracalajurpdf', $data);

        // Landscape format for 10-column worksheet
        $pdf = new \TCPDF('L', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(10, 10, 10);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 8);
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('neracalajurpdf.pdf', 'I');
        exit;
    }
}
