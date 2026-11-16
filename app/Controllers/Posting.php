<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelAkun3;
use App\Models\ModelTransaksi;

class Posting extends BaseController
{
    protected $objNilai;
    protected $objAkun3;
    protected $objTransaksi;

    public function __construct()
    {
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
        $this->objTransaksi = new ModelTransaksi();
    }

    private function generateDataPosting($kodeAkun = null, $tglAwal = null, $tglAkhir = null)
    {
        $dtakun3 = $this->objAkun3->orderBy('kode_akun3', 'ASC')->findAll();

        if (!empty($kodeAkun)) {
            $allAkun = $this->objAkun3->where('kode_akun3', $kodeAkun)->findAll();
            $rawPosting = $this->objNilai->ambilPosting($kodeAkun, $tglAwal, $tglAkhir);
        } else {
            $allAkun = $dtakun3;
            $rawPosting = $this->objNilai->ambilPosting(null, $tglAwal, $tglAkhir);
        }

        // Group transactions by kode_akun3
        $mapPosting = [];
        foreach ($rawPosting as $r) {
            $mapPosting[$r->kode_akun3][] = $r;
        }

        $bukuBesar = [];
        foreach ($allAkun as $ak) {
            $akObj = (object)$ak;
            $kode  = $akObj->kode_akun3;
            $nama  = $akObj->nama_akun3 ?? $akObj->nama_akun ?? '';
            $kepala = substr((string)$kode, 0, 1);

            $isNormalDebet = ($kode === '3201' || $kode === '4202' || in_array($kepala, ['1', '5']));
            if ($kode === '1202') {
                $isNormalDebet = false; // Akumulasi penyusutan normal kredit
            }

            $mutasiList = $mapPosting[$kode] ?? [];

            $saldo = 0;
            $rows  = [];
            $totD  = 0;
            $totK  = 0;

            foreach ($mutasiList as $m) {
                $d = floatval($m->debet ?? $m->debit ?? 0);
                $k = floatval($m->kredit ?? 0);
                $totD += $d;
                $totK += $k;

                if ($isNormalDebet) {
                    $saldo += ($d - $k);
                    $m->saldo_debet  = ($saldo >= 0) ? $saldo : 0;
                    $m->saldo_kredit = ($saldo < 0) ? abs($saldo) : 0;
                } else {
                    $saldo += ($k - $d);
                    $m->saldo_kredit = ($saldo >= 0) ? $saldo : 0;
                    $m->saldo_debet  = ($saldo < 0) ? abs($saldo) : 0;
                }

                $rows[] = $m;
            }

            $bukuBesar[] = [
                'kode_akun3'   => $kode,
                'nama_akun3'   => $nama,
                'posisiNormal' => $isNormalDebet ? 'debet' : 'kredit',
                'mutasi'       => $rows,
                'totDebet'     => $totD,
                'totKredit'    => $totK,
                'saldoAkhir'   => $saldo,
            ];
        }

        return [
            'dtakun3'    => $dtakun3,
            'kode_akun3' => $kodeAkun,
            'tgl_awal'   => $tglAwal,
            'tgl_akhir'  => $tglAkhir,
            'bukuBesar'  => $bukuBesar,
        ];
    }

    public function index()
    {
        $kodeAkun  = $this->request->getVar('kode_akun3');
        $tglAwal   = $this->request->getVar('tgl_awal');
        $tglAkhir  = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataPosting($kodeAkun, $tglAwal, $tglAkhir);

        return view('posting/index', $data);
    }

    public function cetakposting()
    {
        $kodeAkun  = $this->request->getVar('kode_akun3');
        $tglAwal   = $this->request->getVar('tgl_awal');
        $tglAkhir  = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataPosting($kodeAkun, $tglAwal, $tglAkhir);

        return view('posting/cetakposting', $data);
    }

    public function postingpdf()
    {
        $kodeAkun  = $this->request->getVar('kode_akun3');
        $tglAwal   = $this->request->getVar('tgl_awal');
        $tglAkhir  = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataPosting($kodeAkun, $tglAwal, $tglAkhir);

        $html = view('posting/postingpdf', $data);

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 12, 15);
        $pdf->SetAutoPageBreak(TRUE, 12);
        $pdf->AddPage();
        $pdf->SetFont('times', '', 9);
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('Buku_Besar_PERUSAHAAN_AKN_IPB.pdf', 'I');
        exit;
    }
}