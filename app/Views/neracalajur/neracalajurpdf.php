<!DOCTYPE html>
<html>
<head>
    <title>Worksheet - PERUSAHAAN AKN-IPB</title>
    <style>
        body {
            font-family: 'times', serif;
            font-size: 7.5pt;
            color: #000;
        }
        .header-kop {
            text-align: center;
            margin-bottom: 6px;
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
            font-size: 9.5pt;
            font-weight: bold;
        }
        .currency {
            text-align: right;
            font-size: 8pt;
            margin-bottom: 3px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
        }
        th, td {
            border: 0.5px solid #000;
            padding: 3px 2px;
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
        <div class="title">WORKSHEET</div>
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
        (Rp000)
    </div>

    <table cellpadding="2" cellspacing="0" border="1">
        <thead>
            <tr>
                <th width="7%" rowspan="2" class="text-center"><b>No<br>Akun</b></th>
                <th width="17%" rowspan="2" class="text-center"><b>Nama Akun</b></th>
                <th width="15.2%" colspan="2" class="text-center"><b>Neraca Saldo</b></th>
                <th width="15.2%" colspan="2" class="text-center"><b>Jurnal<br>Penyesuaian</b></th>
                <th width="15.2%" colspan="2" class="text-center"><b>Neraca Saldo<br>Setelah Penyesuaian</b></th>
                <th width="15.2%" colspan="2" class="text-center"><b>Laba Rugi</b></th>
                <th width="15.2%" colspan="2" class="text-center"><b>Neraca</b></th>
            </tr>
            <tr>
                <th width="7.6%" class="text-center"><b>Db</b></th>
                <th width="7.6%" class="text-center"><b>Kr</b></th>
                <th width="7.6%" class="text-center"><b>Db</b></th>
                <th width="7.6%" class="text-center"><b>Kr</b></th>
                <th width="7.6%" class="text-center"><b>Db</b></th>
                <th width="7.6%" class="text-center"><b>Kr</b></th>
                <th width="7.6%" class="text-center"><b>Db</b></th>
                <th width="7.6%" class="text-center"><b>Kr</b></th>
                <th width="7.6%" class="text-center"><b>Db</b></th>
                <th width="7.6%" class="text-center"><b>Kr</b></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dtlajur as $row) : ?>
                <tr>
                    <td width="7%" class="text-center"><?= $row->kode_akun3 ?></td>
                    <td width="17%"><?= esc($row->nama_akun3) ?></td>
                    <td width="7.6%" class="text-right"><?= $row->ns_debet > 0 ? number_format($row->ns_debet / 1000, 0, ',', '.') : '-' ?></td>
                    <td width="7.6%" class="text-right"><?= $row->ns_kredit > 0 ? number_format($row->ns_kredit / 1000, 0, ',', '.') : '-' ?></td>
                    <td width="7.6%" class="text-right"><?= $row->ajp_debet > 0 ? number_format($row->ajp_debet / 1000, 0, ',', '.') : '-' ?></td>
                    <td width="7.6%" class="text-right"><?= $row->ajp_kredit > 0 ? number_format($row->ajp_kredit / 1000, 0, ',', '.') : '-' ?></td>
                    <td width="7.6%" class="text-right"><?= $row->nsd_debet > 0 ? number_format($row->nsd_debet / 1000, 0, ',', '.') : '-' ?></td>
                    <td width="7.6%" class="text-right"><?= $row->nsd_kredit > 0 ? number_format($row->nsd_kredit / 1000, 0, ',', '.') : '-' ?></td>
                    <td width="7.6%" class="text-right"><?= $row->lr_debet > 0 ? number_format($row->lr_debet / 1000, 0, ',', '.') : '-' ?></td>
                    <td width="7.6%" class="text-right"><?= $row->lr_kredit > 0 ? number_format($row->lr_kredit / 1000, 0, ',', '.') : '-' ?></td>
                    <td width="7.6%" class="text-right"><?= $row->n_debet > 0 ? number_format($row->n_debet / 1000, 0, ',', '.') : '-' ?></td>
                    <td width="7.6%" class="text-right"><?= $row->n_kredit > 0 ? number_format($row->n_kredit / 1000, 0, ',', '.') : '-' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="font-weight: bold;">
                <td colspan="2" class="text-center"><b>TOTAL</b></td>
                <td class="text-right"><b><?= number_format($tot_ns_debet / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ns_kredit / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ajp_debet / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ajp_kredit / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_nsd_debet / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_nsd_kredit / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_lr_debet / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_lr_kredit / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_n_debet / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_n_kredit / 1000, 0, ',', '.') ?></b></td>
            </tr>
            <tr style="font-weight: bold;">
                <td colspan="2" class="text-center"><b>Laba (Rugi)</b></td>
                <td colspan="6" class="text-center">-</td>
                <td class="text-right"><b><?= $laba_bersih >= 0 ? number_format($laba_bersih / 1000, 0, ',', '.') : '-' ?></b></td>
                <td class="text-right"><b><?= $laba_bersih < 0 ? number_format(abs($laba_bersih) / 1000, 0, ',', '.') : '-' ?></b></td>
                <td class="text-right"><b><?= $laba_bersih < 0 ? number_format(abs($laba_bersih) / 1000, 0, ',', '.') : '-' ?></b></td>
                <td class="text-right"><b><?= $laba_bersih >= 0 ? number_format($laba_bersih / 1000, 0, ',', '.') : '-' ?></b></td>
            </tr>
            <tr style="font-weight: bold;">
                <td colspan="2" class="text-center"><b>TOTAL</b></td>
                <td class="text-right"><b><?= number_format($tot_ns_debet / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ns_kredit / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ajp_debet / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ajp_kredit / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_nsd_debet / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format($tot_nsd_kredit / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format(max($tot_lr_debet, $tot_lr_kredit) / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format(max($tot_lr_debet, $tot_lr_kredit) / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format(max($tot_n_debet, $tot_n_kredit) / 1000, 0, ',', '.') ?></b></td>
                <td class="text-right"><b><?= number_format(max($tot_n_debet, $tot_n_kredit) / 1000, 0, ',', '.') ?></b></td>
            </tr>
        </tfoot>
    </table>

</body>
</html>