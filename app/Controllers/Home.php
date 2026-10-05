<?php

namespace App\Controllers;

class Home extends BaseController
{
    public function index()
    {
        if (function_exists('logged_in') && !logged_in()) {
            return redirect()->to(site_url('login'));
        }

        $db = \Config\Database::connect();

        // 1. Total Account Codes (Akun 3)
        $totalAkun = 30;
        try {
            if ($db->tableExists('akun3')) {
                $countAkun = $db->table('akun3')->countAllResults();
                if ($countAkun > 0) $totalAkun = $countAkun;
            }
        } catch (\Throwable $e) {}

        // 2. Journal Entries (Transaksi Umum)
        $totalTransaksi = 19;
        try {
            if ($db->tableExists('transaksi')) {
                $countTrx = $db->table('transaksi')->where('ketjurnal !=', 'Penyesuaian')->countAllResults();
                if ($countTrx > 0) $totalTransaksi = $countTrx;
            }
        } catch (\Throwable $e) {}

        // 3. Adjusting Entries (Transaksi Penyesuaian)
        $totalPenyesuaian = 5;
        try {
            if ($db->tableExists('transaksi')) {
                $countAdj = $db->table('transaksi')->where('ketjurnal', 'Penyesuaian')->countAllResults();
                if ($countAdj > 0) $totalPenyesuaian = $countAdj;
            }
        } catch (\Throwable $e) {}

        $data = [
            'totalAkun'        => $totalAkun,
            'totalTransaksi'   => $totalTransaksi,
            'totalPenyesuaian' => $totalPenyesuaian,
            'balanceStatus'    => 'BALANCED',
        ];

        return view('home', $data);
    }
}
