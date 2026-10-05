<?php

namespace App\Controllers;

use App\Controllers\BaseController;
use App\Models\ModelNilai;
use App\Models\ModelAkun3;

class ArusKas extends BaseController
{
    protected $objNilai;
    protected $objAkun3;

    public function __construct()
    {
        $this->objNilai = new ModelNilai();
        $this->objAkun3 = new ModelAkun3();
    }

    private function generateDataArusKas($tglAwal = null, $tglAkhir = null)
    {
        $db = \Config\Database::connect();

        // 1. Hitung Saldo Kas Awal (jika ada filter tanggal awal)
        $saldoAwal = 0;
        if (!empty($tglAwal)) {
            $bAwal = $db->table('tbl_nilai')
                ->select('SUM(tbl_nilai.debet) as tot_debet, SUM(tbl_nilai.kredit) as tot_kredit')
                ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi = tbl_nilai.id_transaksi')
                ->where('tbl_nilai.kode_akun3', '1101')
                ->where('tbl_transaksi.ketjurnal !=', 'Penyesuaian')
                ->where('tbl_transaksi.tanggal <', $tglAwal);
            $resAwal = $bAwal->get()->getRow();
            if ($resAwal) {
                $saldoAwal = floatval($resAwal->tot_debet ?? 0) - floatval($resAwal->tot_kredit ?? 0);
            }
        }

        // 2. Ambil semua baris transaksi yang melibatkan Kas (1101) pada periode
        $bKas = $db->table('tbl_nilai')
            ->select('tbl_nilai.*, tbl_transaksi.tanggal, tbl_transaksi.kwitansi, tbl_transaksi.deskripsi, tbl_transaksi.ketjurnal')
            ->join('tbl_transaksi', 'tbl_transaksi.id_transaksi = tbl_nilai.id_transaksi')
            ->where('tbl_nilai.kode_akun3', '1101')
            ->where('tbl_transaksi.ketjurnal !=', 'Penyesuaian');

        if (!empty($tglAwal)) {
            $bKas->where('tbl_transaksi.tanggal >=', $tglAwal);
        }
        if (!empty($tglAkhir)) {
            $bKas->where('tbl_transaksi.tanggal <=', $tglAkhir);
        }

        $bKas->orderBy('tbl_transaksi.tanggal', 'ASC')
             ->orderBy('tbl_transaksi.id_transaksi', 'ASC');

        $kasRows = $bKas->get()->getResultObject();

        $operasiMasuk     = [];
        $operasiKeluar    = [];
        $investasiMasuk   = [];
        $investasiKeluar  = [];
        $pendanaanMasuk   = [];
        $pendanaanKeluar  = [];

        $totOperasiMasuk    = 0;
        $totOperasiKeluar   = 0;
        $totInvestasiMasuk  = 0;
        $totInvestasiKeluar = 0;
        $totPendanaanMasuk  = 0;
        $totPendanaanKeluar = 0;

        foreach ($kasRows as $kr) {
            $debet  = floatval($kr->debet);
            $kredit = floatval($kr->kredit);
            $isMasuk = ($debet > 0);
            $nominal = $isMasuk ? $debet : $kredit;

            if ($nominal <= 0) {
                continue;
            }

            // Cari akun lawan dalam transaksi yang sama di sisi yang berlawanan
            $bLawan = $db->table('tbl_nilai')
                ->select('tbl_nilai.*, akun3s.nama_akun3')
                ->join('akun3s', 'akun3s.kode_akun3 = tbl_nilai.kode_akun3', 'LEFT')
                ->where('tbl_nilai.id_transaksi', $kr->id_transaksi)
                ->where('tbl_nilai.kode_akun3 !=', '1101');

            if ($isMasuk) {
                // Kas di DEBET, akun lawan harus di KREDIT
                $bLawan->where('tbl_nilai.kredit >', 0);
            } else {
                // Kas di KREDIT, akun lawan harus di DEBET
                $bLawan->where('tbl_nilai.debet >', 0);
            }

            $lawanRows = $bLawan->get()->getResultObject();

            $lawanKode = !empty($lawanRows) ? $lawanRows[0]->kode_akun3 : '';
            $lawanNama = !empty($lawanRows) ? $lawanRows[0]->nama_akun3 : $kr->deskripsi;
            $kepala    = substr((string)$lawanKode, 0, 1);

            // Klasifikasi berdasarkan akun lawan
            if ($lawanKode === '3101') {
                // Setoran Modal Pemilik
                if ($isMasuk) {
                    $pendanaanMasuk['Setoran Modal Awal Pemilik (Tuan Najwan)'] = ($pendanaanMasuk['Setoran Modal Awal Pemilik (Tuan Najwan)'] ?? 0) + $nominal;
                    $totPendanaanMasuk += $nominal;
                } else {
                    $pendanaanKeluar['Penarikan Modal Pemilik'] = ($pendanaanKeluar['Penarikan Modal Pemilik'] ?? 0) + $nominal;
                    $totPendanaanKeluar += $nominal;
                }
            } elseif ($lawanKode === '3201') {
                // Prive Pemilik
                $pendanaanKeluar['Pengambilan Prive Pemilik (Tuan Najwan)'] = ($pendanaanKeluar['Pengambilan Prive Pemilik (Tuan Najwan)'] ?? 0) + $nominal;
                $totPendanaanKeluar += $nominal;
            } elseif (str_starts_with($lawanKode, '12')) {
                // Aset Tetap / Investasi
                if ($isMasuk) {
                    $investasiMasuk['Penjualan Aset Tetap (' . $lawanNama . ')'] = ($investasiMasuk['Penjualan Aset Tetap (' . $lawanNama . ')'] ?? 0) + $nominal;
                    $totInvestasiMasuk += $nominal;
                } else {
                    $investasiKeluar['Pembelian Peralatan / Aset Tetap (' . $lawanNama . ')'] = ($investasiKeluar['Pembelian Peralatan / Aset Tetap (' . $lawanNama . ')'] ?? 0) + $nominal;
                    $totInvestasiKeluar += $nominal;
                }
            } elseif ($lawanKode === '1102' || $lawanKode === '4101') {
                // Penerimaan dari Pelanggan / Piutang Usaha
                $operasiMasuk['Penerimaan Kas dari Pelanggan / Pelunasan Piutang'] = ($operasiMasuk['Penerimaan Kas dari Pelanggan / Pelunasan Piutang'] ?? 0) + $nominal;
                $totOperasiMasuk += $nominal;
            } elseif ($lawanKode === '2103') {
                // Pendapatan Diterima di Muka
                $operasiMasuk['Penerimaan Pendapatan Diterima di Muka'] = ($operasiMasuk['Penerimaan Pendapatan Diterima di Muka'] ?? 0) + $nominal;
                $totOperasiMasuk += $nominal;
            } elseif ($lawanKode === '2101') {
                // Pembayaran Utang Usaha
                $operasiKeluar['Pembayaran Utang Usaha ke Pemasok'] = ($operasiKeluar['Pembayaran Utang Usaha ke Pemasok'] ?? 0) + $nominal;
                $totOperasiKeluar += $nominal;
            } elseif ($lawanKode === '1104') {
                // Sewa Dibayar Dimuka
                $operasiKeluar['Pembayaran Sewa Gedung Dibayar di Muka'] = ($operasiKeluar['Pembayaran Sewa Gedung Dibayar di Muka'] ?? 0) + $nominal;
                $totOperasiKeluar += $nominal;
            } elseif ($lawanKode === '1105') {
                // Asuransi Dibayar Dimuka
                $operasiKeluar['Pembayaran Premi Asuransi Dibayar di Muka'] = ($operasiKeluar['Pembayaran Premi Asuransi Dibayar di Muka'] ?? 0) + $nominal;
                $totOperasiKeluar += $nominal;
            } elseif ($lawanKode === '1103') {
                // Perlengkapan Kantor
                $operasiKeluar['Pembelian Perlengkapan Kantor Tunai'] = ($operasiKeluar['Pembelian Perlengkapan Kantor Tunai'] ?? 0) + $nominal;
                $totOperasiKeluar += $nominal;
            } elseif ($lawanKode === '5101' || $lawanKode === '4202') {
                // Beban Gaji
                $operasiKeluar['Pembayaran Beban Gaji Karyawan'] = ($operasiKeluar['Pembayaran Beban Gaji Karyawan'] ?? 0) + $nominal;
                $totOperasiKeluar += $nominal;
            } elseif ($lawanKode === '5102') {
                // Beban Iklan
                $operasiKeluar['Pembayaran Beban Iklan Surat Kabar'] = ($operasiKeluar['Pembayaran Beban Iklan Surat Kabar'] ?? 0) + $nominal;
                $totOperasiKeluar += $nominal;
            } elseif ($lawanKode === '5104') {
                // Beban Telepon
                $operasiKeluar['Pembayaran Beban Telepon'] = ($operasiKeluar['Pembayaran Beban Telepon'] ?? 0) + $nominal;
                $totOperasiKeluar += $nominal;
            } elseif ($lawanKode === '5105') {
                // Beban Listrik
                $operasiKeluar['Pembayaran Beban Listrik'] = ($operasiKeluar['Pembayaran Beban Listrik'] ?? 0) + $nominal;
                $totOperasiKeluar += $nominal;
            } else {
                // Operasi lainnya
                if ($isMasuk) {
                    $label = 'Penerimaan Operasional Lainnya (' . $lawanNama . ')';
                    $operasiMasuk[$label] = ($operasiMasuk[$label] ?? 0) + $nominal;
                    $totOperasiMasuk += $nominal;
                } else {
                    $label = 'Pengeluaran Operasional Lainnya (' . $lawanNama . ')';
                    $operasiKeluar[$label] = ($operasiKeluar[$label] ?? 0) + $nominal;
                    $totOperasiKeluar += $nominal;
                }
            }
        }

        $netOperasi   = $totOperasiMasuk - $totOperasiKeluar;
        $netInvestasi = $totInvestasiMasuk - $totInvestasiKeluar;
        $netPendanaan = $totPendanaanMasuk - $totPendanaanKeluar;
        $kenaikanKas  = $netOperasi + $netInvestasi + $netPendanaan;
        $saldoAkhir   = $saldoAwal + $kenaikanKas;

        return [
            'operasiMasuk'        => $operasiMasuk,
            'operasiKeluar'       => $operasiKeluar,
            'totOperasiMasuk'     => $totOperasiMasuk,
            'totOperasiKeluar'    => $totOperasiKeluar,
            'netOperasi'          => $netOperasi,

            'investasiMasuk'      => $investasiMasuk,
            'investasiKeluar'     => $investasiKeluar,
            'totInvestasiMasuk'   => $totInvestasiMasuk,
            'totInvestasiKeluar'  => $totInvestasiKeluar,
            'netInvestasi'        => $netInvestasi,

            'pendanaanMasuk'      => $pendanaanMasuk,
            'pendanaanKeluar'     => $pendanaanKeluar,
            'totPendanaanMasuk'   => $totPendanaanMasuk,
            'totPendanaanKeluar'  => $totPendanaanKeluar,
            'netPendanaan'        => $netPendanaan,

            'kenaikanKas'         => $kenaikanKas,
            'saldoAwal'           => $saldoAwal,
            'saldoAkhir'          => $saldoAkhir,
            'tgl_awal'            => $tglAwal,
            'tgl_akhir'           => $tglAkhir,
        ];
    }

    public function index()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataArusKas($tglAwal, $tglAkhir);

        return view('aruskas/index', $data);
    }

    public function aruskaspdf()
    {
        $tglAwal  = $this->request->getVar('tgl_awal');
        $tglAkhir = $this->request->getVar('tgl_akhir');

        $data = $this->generateDataArusKas($tglAwal, $tglAkhir);

        $html = view('aruskas/aruskaspdf', $data);

        $pdf = new \TCPDF('P', 'mm', 'A4', true, 'UTF-8', false);
        $pdf->setPrintHeader(false);
        $pdf->setPrintFooter(false);
        $pdf->SetMargins(15, 15, 15);
        $pdf->AddPage();
        $pdf->SetFont('helvetica', '', 9);
        $pdf->writeHTML($html, true, false, true, false, '');

        $this->response->setHeader('Content-Type', 'application/pdf');
        $pdf->Output('laporan_aruskas.pdf', 'I');
        exit;
    }
}
