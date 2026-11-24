<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelTransaksi;

class JurnalPenyesuaian extends BaseController
{
    protected $objNilai;
    protected $objTransaksi;

    public function __construct()
    {
        $this->objNilai = new ModelNilai();
        $this->objTransaksi = new ModelTransaksi();
    }

    public function index()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $dtjurnal = $this->objNilai->ambilJurnalPenyesuaian($tglAwal, $tglAkhir);

        $totDebet = 0;
        $totKredit = 0;
        foreach ($dtjurnal as $row) {
            $totDebet += ($row->debet ?? $row->debit ?? 0);
            $totKredit += ($row->kredit ?? 0);
        }

        $data = [
            'dtjurnal'   => $dtjurnal,
            'tgl_awal'   => $tglAwal,
            'tgl_akhir'  => $tglAkhir,
            'totDebet'   => $totDebet,
            'totKredit'  => $totKredit,
            'isBalance'  => ($totDebet == $totKredit && $totDebet > 0),
        ];

        return view('jurnalpenyesuaian/index', $data);
    }

    public function cetakjurnal()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $dtjurnal = $this->objNilai->ambilJurnalPenyesuaian($tglAwal, $tglAkhir);

        $totDebet = 0;
        $totKredit = 0;
        foreach ($dtjurnal as $row) {
            $totDebet += ($row->debet ?? $row->debit ?? 0);
            $totKredit += ($row->kredit ?? 0);
        }

        $data = [
            'dtjurnal'  => $dtjurnal,
            'tgl_awal'  => $tglAwal,
            'tgl_akhir' => $tglAkhir,
            'totDebet'  => $totDebet,
            'totKredit' => $totKredit,
        ];

        return view('jurnalpenyesuaian/cetakjurnal', $data);
    }
}
