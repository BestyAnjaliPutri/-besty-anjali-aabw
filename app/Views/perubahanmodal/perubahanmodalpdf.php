<!DOCTYPE html>
<html>
<head>
    <title>Laporan Perubahan Modal PDF</title>
    <style>
        body {
            font-family: helvetica, sans-serif;
            font-size: 9pt;
            color: #000;
        }
        h2 {
            text-align: center;
            font-size: 14pt;
            margin-bottom: 2px;
            font-weight: bold;
        }
        .periode {
            text-align: center;
            font-size: 9pt;
            margin-top: 0;
            margin-bottom: 20px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        td {
            padding: 5px 3px;
        }
        .border-top {
            border-top: 1px solid #000;
        }
        .border-bottom {
            border-bottom: 1px solid #000;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .signature {
            margin-top: 30px;
            font-size: 9pt;
        }
    </style>
</head>
<body>

    <h2>Laporan Perubahan Modal</h2>
    <div class="periode">
        <?php if (!empty($tgl_awal) && !empty($tgl_akhir)) : ?>
            Periode : <?= date('d F Y', strtotime($tgl_awal)) ?> s/d <?= date('d F Y', strtotime($tgl_akhir)) ?>
        <?php else : ?>
            Periode : 01 Desember 2025 s/d 31 Desember 2025
        <?php endif; ?>
    </div>

    <table cellpadding="4" cellspacing="0">
        <tbody>
            <tr class="border-top">
                <td width="70%"><b>Modal Awal Pemilik</b></td>
                <td width="30%" class="text-right"><b><?= number_format($modalAwal) ?></b></td>
            </tr>
            <tr>
                <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Laba Bersih Periode Berjalan</td>
                <td width="30%" class="text-right"><?= number_format($labaBersih) ?></td>
            </tr>
            <tr>
                <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Prive Pemilik</td>
                <td width="30%" class="text-right">(<?= number_format($prive) ?>)</td>
            </tr>
            <tr class="border-top">
                <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<b><?= $perubahanNet >= 0 ? 'Kenaikan Bersih Modal' : 'Penurunan Bersih Modal' ?></b></td>
                <td width="30%" class="text-right"><b><?= number_format($perubahanNet) ?></b></td>
            </tr>
        </tbody>
        <tfoot>
            <tr class="border-top border-bottom" style="background-color: #f5f5f5;">
                <td width="70%"><b>MODAL AKHIR PERIODE</b></td>
                <td width="30%" class="text-right"><b>Rp <?= number_format($modalAkhir) ?></b></td>
            </tr>
        </tfoot>
    </table>

    <div class="signature">
        <p>
            Bogor, 31 Desember 2025<br>
            Pimpinan AKN<br><br><br><br>
        </p>
    </div>

</body>
</html>
