<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perubahan Modal - PERUSAHAAN AKN-IPB</title>
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
        td {
            padding: 5px 3px;
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
        <div class="title">LAPORAN PERUBAHAN MODAL</div>
        <div class="period">
            Untuk Tahun Yang Berakhir <?= !empty($tgl_akhir) ? date('d F Y', strtotime($tgl_akhir)) : '31 Desember 2025' ?>
        </div>
    </div>

    <table cellpadding="4" cellspacing="0">
        <tbody>
            <tr class="border-top">
                <td width="70%"><b>Modal Awal Pemilik</b></td>
                <td width="30%" class="text-right"><b><?= number_format($modalAwal, 0, ',', '.') ?></b></td>
            </tr>
            <tr>
                <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Laba Bersih Periode Berjalan</td>
                <td width="30%" class="text-right"><?= number_format($labaBersih, 0, ',', '.') ?></td>
            </tr>
            <tr>
                <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Prive Pemilik</td>
                <td width="30%" class="text-right">(<?= number_format($prive, 0, ',', '.') ?>)</td>
            </tr>
            <tr class="border-top">
                <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<b><?= $perubahanNet >= 0 ? 'Kenaikan Bersih Modal' : 'Penurunan Bersih Modal' ?></b></td>
                <td width="30%" class="text-right"><b><?= number_format($perubahanNet, 0, ',', '.') ?></b></td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="border-top border-double">
                <td width="70%"><b>MODAL AKHIR PERIODE</b></td>
                <td width="30%" class="text-right"><b>Rp <?= number_format($modalAkhir, 0, ',', '.') ?></b></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>