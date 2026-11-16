<!DOCTYPE html>
<html>
<head>
    <title>Laporan Laba Rugi - PERUSAHAAN AKN-IPB</title>
    <style>
        body {
            font-family: 'times', serif;
            font-size: 9.5pt;
            color: #000;
        }
        .header-kop {
            text-align: center;
            margin-bottom: 12px;
        }
        .company {
            font-size: 13pt;
            font-weight: bold;
        }
        .title {
            font-size: 12pt;
            font-weight: bold;
            margin: 2px 0;
        }
        .period {
            font-size: 10pt;
            font-weight: bold;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9.5pt;
        }
        th, td {
            padding: 4px 3px;
        }
        .border-top {
            border-top: 0.5px solid #000;
        }
        .border-bottom {
            border-bottom: 0.5px solid #000;
        }
        .border-double {
            border-bottom: 1.5px double #000;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
    </style>
</head>
<body>

    <div class="header-kop">
        <div class="company">PERUSAHAAN AKN-IPB</div>
        <div class="title">LAPORAN LABA RUGI</div>
        <div class="period">
            Untuk Tahun Yang Berakhir <?= !empty($tgl_akhir) ? date('d F Y', strtotime($tgl_akhir)) : '31 Desember 2025' ?>
        </div>
    </div>

    <table cellpadding="4" cellspacing="0">
        <!-- 1. PENDAPATAN -->
        <thead>
            <tr>
                <th width="15%" class="text-left border-top border-bottom"><b>Kode</b></th>
                <th width="55%" class="text-left border-top border-bottom"><b>Pendapatan Usaha</b></th>
                <th width="30%" class="text-right border-top border-bottom"><b>Jumlah (Rp)</b></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendapatan as $p) : ?>
                <tr>
                    <td width="15%"><?= $p->kode_akun3 ?></td>
                    <td width="55%"><?= esc($p->nama_akun3) ?></td>
                    <td width="30%" class="text-right"><?= number_format($p->jumlah, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="border-top">
                <td width="15%"></td>
                <td width="55%"><b>Total Pendapatan</b></td>
                <td width="30%" class="text-right"><b><?= number_format($totPendapatan, 0, ',', '.') ?></b></td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
        </tbody>

        <!-- 2. BEBAN -->
        <thead>
            <tr>
                <th width="15%" class="text-left border-top border-bottom"><b>Kode</b></th>
                <th width="55%" class="text-left border-top border-bottom"><b>Beban Usaha</b></th>
                <th width="30%" class="text-right border-top border-bottom"><b>Jumlah (Rp)</b></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($beban as $b) : ?>
                <tr>
                    <td width="15%"><?= $b->kode_akun3 ?></td>
                    <td width="55%"><?= esc($b->nama_akun3) ?></td>
                    <td width="30%" class="text-right"><?= number_format($b->jumlah, 0, ',', '.') ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="border-top">
                <td width="15%"></td>
                <td width="55%"><b>Total Beban</b></td>
                <td width="30%" class="text-right"><b><?= number_format($totBeban, 0, ',', '.') ?></b></td>
            </tr>
            <tr><td colspan="3">&nbsp;</td></tr>
        </tbody>

        <!-- 3. LABA / RUGI BERSIH -->
        <tfoot>
            <tr class="border-top border-double">
                <td width="15%"></td>
                <td width="55%"><b><?= $labaBersih >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' ?></b></td>
                <td width="30%" class="text-right"><b>Rp <?= number_format($labaBersih, 0, ',', '.') ?></b></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>