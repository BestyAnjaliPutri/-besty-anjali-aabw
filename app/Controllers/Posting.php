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

    public function index()
    {
        $dtakun3   = $this->objAkun3->orderBy('kode_akun3', 'ASC')->findAll();
        $kodeAkun  = $this->request->getVar('kode_akun3');
        $tglAwal   = $this->request->getVar('tgl_awal');
        $tglAkhir  = $this->request->getVar('tgl_akhir');

        $selectedAkun = null;
        $posisiNormal = 'debet';
        if (!empty($kodeAkun)) {
            $selectedAkun = $this->objAkun3->where('kode_akun3', $kodeAkun)->first();
            $dtposting    = $this->objNilai->ambilPosting($kodeAkun, $tglAwal, $tglAkhir);
            $kepala = substr((string)$kodeAkun, 0, 1);
            $posisiNormal = in_array($kepala, ['2', '3', '4']) ? 'kredit' : 'debet';
        } else {
            $dtposting    = $this->objNilai->ambilPosting(null, $tglAwal, $tglAkhir);
        }

        $saldoBerjalan = 0;
        $totDebet      = 0;
        $totKredit     = 0;
        foreach ($dtposting as $row) {
            $valDebet  = $row->debet ?? $row->debit ?? 0;
            $valKredit = $row->kredit ?? 0;

            $totDebet  += $valDebet;
            $totKredit += $valKredit;

            $saldoBerjalan += ($valDebet - $valKredit);
            $row->saldo_debet  = ($saldoBerjalan >= 0) ? $saldoBerjalan : 0;
            $row->saldo_kredit = ($saldoBerjalan < 0) ? abs($saldoBerjalan) : 0;
        }
        $saldoAkhir = $saldoBerjalan;

        $data = [
            'dtakun3'       => $dtakun3,
            'selectedAkun'  => $selectedAkun,
            'kode_akun3'    => $kodeAkun,
            'dtposting'     => $dtposting,
            'tgl_awal'      => $tglAwal,
            'tgl_akhir'     => $tglAkhir,
            'totDebet'      => $totDebet,
            'totKredit'     => $totKredit,
            'saldoAkhir'    => $saldoAkhir,
            'posisiNormal'  => $posisiNormal,
        ];

        return view('posting/index', $data);
    }

    public function cetakposting()
    {
        $kodeAkun  = $this->request->getVar('kode_akun3');
        $tglAwal   = $this->request->getVar('tgl_awal');
        $tglAkhir  = $this->request->getVar('tgl_akhir');

        $selectedAkun = null;
        $posisiNormal = 'debet';
        if (!empty($kodeAkun)) {
            $selectedAkun = $this->objAkun3->where('kode_akun3', $kodeAkun)->first();
            $dtposting    = $this->objNilai->ambilPosting($kodeAkun, $tglAwal, $tglAkhir);
            $kepala = substr((string)$kodeAkun, 0, 1);
            $posisiNormal = in_array($kepala, ['2', '3', '4']) ? 'kredit' : 'debet';
        } else {
            $dtposting    = $this->objNilai->ambilPosting(null, $tglAwal, $tglAkhir);
        }

        $saldoBerjalan = 0;
        $totDebet      = 0;
        $totKredit     = 0;
        foreach ($dtposting as $row) {
            $valDebet  = $row->debet ?? $row->debit ?? 0;
            $valKredit = $row->kredit ?? 0;

            $totDebet  += $valDebet;
            $totKredit += $valKredit;

            $saldoBerjalan += ($valDebet - $valKredit);
            $row->saldo_debet  = ($saldoBerjalan >= 0) ? $saldoBerjalan : 0;
            $row->saldo_kredit = ($saldoBerjalan < 0) ? abs($saldoBerjalan) : 0;
        }
        $saldoAkhir = $saldoBerjalan;

        $data = [
            'selectedAkun'  => $selectedAkun,
            'kode_akun3'    => $kodeAkun,
            'dtposting'     => $dtposting,
            'tgl_awal'      => $tglAwal,
            'tgl_akhir'     => $tglAkhir,
            'totDebet'      => $totDebet,
            'totKredit'     => $totKredit,
            'saldoAkhir'    => $saldoAkhir,
            'posisiNormal'  => $posisiNormal,
        ];

        return view('posting/cetakposting', $data);
    }
}
