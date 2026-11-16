<!DOCTYPE html>
<html>
<head>
    <title>Neraca Saldo - PERUSAHAAN AKN-IPB</title>
    <style>
        body {
            font-family: 'times', serif;
            font-size: 9pt;
            color: #000;
        }
        .header-kop {
            text-align: center;
            margin-bottom: 8px;
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
        .currency {
            text-align: right;
            font-size: 9pt;
            margin-bottom: 4px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
        }
        th, td {
            border: 0.5px solid #000;
            padding: 4px 5px;
        }
        th {
            font-weight: bold;
            text-align: center;
        }
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
    </style>
</head>
<body>

    <div class="header-kop">
        <div class="company">PERUSAHAAN AKN-IPB</div>
        <div class="title">NERACA SALDO</div>
        <div class="period">
            <?php if (!empty($tgl_akhir)) : ?>
                Periode <?= date('d F Y', strtotime($tgl_akhir)) ?>
            <?php elseif (!empty($tgl_awal) && !empty($tgl_akhir)) : ?>
                Periode <?= date('d F Y', strtotime($tgl_awal)) ?> s/d <?= date('d F Y', strtotime($tgl_akhir)) ?>
            <?php else : ?>
                Periode 31 Desember 2025
            <?php endif; ?>
        </div>
    </div>

    <div class="currency">
        (Rp)
    </div>

    <table cellpadding="3" cellspacing="0" border="1">
        <thead>
            <tr>
                <th width="8%" rowspan="2" class="text-center"><b>No</b></th>
                <th width="52%" rowspan="2" class="text-center"><b>Akun</b></th>
                <th width="40%" colspan="2" class="text-center"><b>Saldo</b></th>
            </tr>
            <tr>
                <th width="20%" class="text-center"><b>Debit</b></th>
                <th width="20%" class="text-center"><b>Kredit</b></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dtneraca as $key => $row) : ?>
                <tr>
                    <td width="8%" class="text-center"><?= $key + 1 ?></td>
                    <td width="52%"><?= esc($row->nama_akun3) ?></td>
                    <td width="20%" class="text-right"><?= $row->debet > 0 ? number_format($row->debet, 0, ',', '.') : '-' ?></td>
                    <td width="20%" class="text-right"><?= $row->kredit > 0 ? number_format($row->kredit, 0, ',', '.') : '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="font-weight: bold;">
                <td colspan="2" class="text-center"><b>TOTAL</b></td>
                <td class="text-right"><b><?= number_format($totDebet, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($totKredit, 0, ',', '.') ?></b></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>