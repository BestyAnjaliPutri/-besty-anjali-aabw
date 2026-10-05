<!DOCTYPE html>
<html>
<head>
    <title>Neraca Saldo PDF</title>
    <style>
        body {
            font-family: helvetica, sans-serif;
            font-size: 10pt;
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
        th {
            font-weight: bold;
            padding: 4px 2px;
        }
        td {
            padding: 3px 2px;
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

    <h2>Neraca Saldo</h2>
    <div class="periode">
        <?php if (!empty($tgl_awal) && !empty($tgl_akhir)) : ?>
            Periode : <?= date('d F Y', strtotime($tgl_awal)) ?> s/d <?= date('d F Y', strtotime($tgl_akhir)) ?>
        <?php else : ?>
            Periode : <?= date('d F Y', strtotime($tgl_awal ?? '')) ?> s/d <?= date('d F Y', strtotime($tgl_akhir ?? '')) ?>
        <?php endif; ?>
    </div>

    <table cellpadding="3" cellspacing="0">
        <thead>
            <tr class="border-top">
                <th width="12%">Kode<br>Akun</th>
                <th width="48%">Keterangan</th>
                <th width="40%" colspan="2" class="text-center">Saldo<br><span style="font-weight:normal;">Debit &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Kredit</span></th>
            </tr>
            <tr class="border-bottom">
                <th width="12%"></th>
                <th width="48%"></th>
                <th width="20%" class="text-right"></th>
                <th width="20%" class="text-right"></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dtneraca as $row) : ?>
                <tr>
                    <td width="12%"><?= $row->kode_akun3 ?></td>
                    <td width="48%"><?= $row->nama_akun3 ?></td>
                    <td width="20%" class="text-right"><?= $row->debet > 0 ? number_format($row->debet) : '0' ?></td>
                    <td width="20%" class="text-right"><?= $row->kredit > 0 ? number_format($row->kredit) : '0' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr class="border-top border-bottom">
                <td width="12%"></td>
                <td width="48%"></td>
                <td width="20%" class="text-right"><b><?= number_format($totDebet) ?></b></td>
                <td width="20%" class="text-right"><b><?= number_format($totKredit) ?></b></td>
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
