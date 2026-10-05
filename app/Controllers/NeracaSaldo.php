<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelAkun3;

class NeracaSaldo extends BaseController
{
    protected $objNilai;
    protected $objAkun3;

    public function __construct()
    {
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
    }

    public function index()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $rawNeraca = $this->objNilai->ambilNeracaSaldo($tglAwal, $tglAkhir);

        $dtneraca   = [];
        $totDebet   = 0;
        $totKredit  = 0;

        foreach ($rawNeraca as $row) {
            $kode   = $row->kode_akun3;
            $nama   = $row->nama_akun3;
            $d      = floatval($row->tot_debet ?? 0);
            $k      = floatval($row->tot_kredit ?? 0);
            $kepala = substr((string)$kode, 0, 1);

            // Tentukan posisi saldo debit / kredit berdasarkan saldo normal
            // Kepala 1 (Aset), 5 (Beban), dan akun khusus 3201 (Prive), 4202 (Gaji) = Normal Debit
            if ($kode === '3201' || $kode === '4202' || in_array($kepala, ['1', '5'])) {
                $saldo = $d - $k;
                $valDebet  = ($saldo >= 0) ? $saldo : 0;
                $valKredit = ($saldo < 0) ? abs($saldo) : 0;
            } else {
                // Kepala 2 (Kewajiban), 3 (Modal), 4 (Pendapatan) = Normal Kredit
                $saldo = $k - $d;
                $valKredit = ($saldo >= 0) ? $saldo : 0;
                $valDebet  = ($saldo < 0) ? abs($saldo) : 0;
            }

            if ($valDebet != 0 || $valKredit != 0) {
                $row->debet  = $valDebet;
                $row->kredit = $valKredit;
                $dtneraca[]  = $row;

                $totDebet  += $valDebet;
                $totKredit += $valKredit;
            }
        }

        $data = [
            'dtneraca'  => $dtneraca,
            'totDebet'  => $totDebet,
            'totKredit' => $totKredit,
            'isBalance' => ($totDebet === $totKredit && $totDebet > 0),
            'tgl_awal'  => $tglAwal,
            'tgl_akhir' => $tglAkhir,
        ];

        return view('neracasaldo/index', $data);
    }

    public function cetakneracasaldo()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $rawNeraca = $this->objNilai->ambilNeracaSaldo($tglAwal, $tglAkhir);

        $dtneraca   = [];
        $totDebet   = 0;
        $totKredit  = 0;

        foreach ($rawNeraca as $row) {
            $kode   = $row->kode_akun3;
            $nama   = $row->nama_akun3;
            $d      = floatval($row->tot_debet ?? 0);
            $k      = floatval($row->tot_kredit ?? 0);
            $kepala = substr((string)$kode, 0, 1);

            if ($kode === '3201' || $kode === '4202' || in_array($kepala, ['1', '5'])) {
                $saldo = $d - $k;
                $valDebet  = ($saldo >= 0) ? $saldo : 0;
                $valKredit = ($saldo < 0) ? abs($saldo) : 0;
            } else {
                $saldo = $k - $d;
                $valKredit = ($saldo >= 0) ? $saldo : 0;
                $valDebet  = ($saldo < 0) ? abs($saldo) : 0;
            }

            if ($valDebet != 0 || $valKredit != 0) {
                $row->debet  = $valDebet;
                $row->kredit = $valKredit;
                $dtneraca[]  = $row;

                $totDebet  += $valDebet;
                $totKredit += $valKredit;
            }
        }

        $data = [
            'dtneraca'  => $dtneraca,
            'totDebet'  => $totDebet,
            'totKredit' => $totKredit,
            'isBalance' => ($totDebet === $totKredit && $totDebet > 0),
            'tgl_awal'  => $tglAwal,
            'tgl_akhir' => $tglAkhir,
        ];

        return view('neracasaldo/cetakneracasaldo', $data);
    }

    public function neracasaldopdf()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $rawNeraca = $this->objNilai->ambilNeracaSaldo($tglAwal, $tglAkhir);

        $dtneraca   = [];
        $totDebet   = 0;
        $totKredit  = 0;

        foreach ($rawNeraca as $row) {
            $kode   = $row->kode_akun3;
            $nama   = $row->nama_akun3;
            $d      = floatval($row->tot_debet ?? 0);
            $k      = floatval($row->tot_kredit ?? 0);
            $kepala = substr((string)$kode, 0, 1);

            if ($kode === '3201' || $kode === '4202' || in_array($kepala, ['1', '5'])) {
                $saldo = $d - $k;
                $valDebet  = ($saldo >= 0) ? $saldo : 0;
                $valKredit = ($saldo < 0) ? abs($saldo) : 0;
            } else {
                $saldo = $k - $d;
                $valKredit = ($saldo >= 0) ? $saldo : 0;
                $valDebet  = ($saldo < 0) ? abs($saldo) : 0;
            }

            if ($valDebet != 0 || $valKredit != 0) {
                $row->debet  = $valDebet;
                $row->kredit = $valKredit;
                $dtneraca[]  = $row;

                $totDebet  += $valDebet;
                $totKredit += $valKredit;
            }
        }

        $data = [
            'dtneraca'  => $dtneraca,
            'totDebet'  => $totDebet,
            'totKredit' => $totKredit,
            'isBalance' => ($totDebet === $totKredit && $totDebet > 0),
            'tgl_awal'  => $tglAwal,
            'tgl_akhir' => $tglAkhir,
        ];

        $html = view('neracasaldo/neracasaldopdf', $data);

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 9);
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('neracasaldopdf.pdf', 'I');
        exit;
    }
}
