<!DOCTYPE html>
<html>
<head>
    <title>Laporan Laba Rugi PDF</title>
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
            margin-bottom: 15px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        th, td {
            padding: 4px 3px;
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
            margin-top: 25px;
            font-size: 9pt;
        }
    </style>
</head>
<body>

    <h2>Laporan Laba Rugi</h2>
    <div class="periode">
        <?php if (!empty($tgl_awal) && !empty($tgl_akhir)) : ?>
            Periode : <?= date('d F Y', strtotime($tgl_awal)) ?> s/d <?= date('d F Y', strtotime($tgl_akhir)) ?>
        <?php else : ?>
            Periode : <?= date('d F Y', strtotime($tgl_awal ?? '')) ?> s/d <?= date('d F Y', strtotime($tgl_akhir ?? '')) ?>
        <?php endif; ?>
    </div>

    <table cellpadding="3" cellspacing="0">
        <!-- 1. PENDAPATAN -->
        <thead>
            <tr class="border-top border-bottom" style="background-color: #f5f5f5;">
                <th width="15%"><b>Kode</b></th>
                <th width="60%"><b>Pendapatan Usaha</b></th>
                <th width="25%" class="text-right"><b>Jumlah</b></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pendapatan as $p) : ?>
                <tr>
                    <td width="15%"><?= $p->kode_akun3 ?></td>
                    <td width="60%"><?= $p->nama_akun3 ?></td>
                    <td width="25%" class="text-right"><?= number_format($p->jumlah) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="border-top">
                <td width="15%"></td>
                <td width="60%"><b>Total Pendapatan</b></td>
                <td width="25%" class="text-right"><b><?= number_format($totPendapatan) ?></b></td>
            </tr>
        </tbody>

        <!-- 2. BEBAN -->
        <thead>
            <tr class="border-top border-bottom" style="background-color: #f5f5f5;">
                <th width="15%"><b>Kode</b></th>
                <th width="60%"><b>Beban Usaha</b></th>
                <th width="25%" class="text-right"><b>Jumlah</b></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($beban as $b) : ?>
                <tr>
                    <td width="15%"><?= $b->kode_akun3 ?></td>
                    <td width="60%"><?= $b->nama_akun3 ?></td>
                    <td width="25%" class="text-right"><?= number_format($b->jumlah) ?></td>
                </tr>
            <?php endforeach; ?>
            <tr class="border-top">
                <td width="15%"></td>
                <td width="60%"><b>Total Beban</b></td>
                <td width="25%" class="text-right"><b><?= number_format($totBeban) ?></b></td>
            </tr>
        </tbody>

        <!-- 3. LABA / RUGI BERSIH -->
        <tfoot>
            <tr class="border-top border-bottom" style="background-color: #eaeaea;">
                <td width="15%"></td>
                <td width="60%"><b><?= $labaBersih >= 0 ? 'Laba Bersih Usaha' : 'Rugi Bersih Usaha' ?></b></td>
                <td width="25%" class="text-right"><b><?= number_format($labaBersih) ?></b></td>
            </tr>
        </tfoot>
    </table>

    <div class="signature">
        <p>
            <?= date('l, d-m-y') ?><br>
            Pimpinan AKN<br><br><br><br>
        </p>
    </div>

</body>
</html>
