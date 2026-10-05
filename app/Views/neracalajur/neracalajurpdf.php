<!DOCTYPE html>
<html>
<head>
    <title>Neraca Lajur PDF</title>
    <style>
        body {
            font-family: helvetica, sans-serif;
            font-size: 8pt;
            color: #000;
        }
        h2 {
            text-align: center;
            font-size: 13pt;
            margin-bottom: 2px;
            font-weight: bold;
        }
        .periode {
            text-align: center;
            font-size: 8pt;
            margin-top: 0;
            margin-bottom: 10px;
        }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 7.5pt;
        }
        th, td {
            padding: 3px 2px;
        }
        .border-top {
            border-top: 1px solid #000;
        }
        .border-bottom {
            border-bottom: 1px solid #000;
        }
        .border-all {
            border: 0.5px solid #666;
        }
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .signature {
            margin-top: 20px;
            font-size: 8pt;
        }
    </style>
</head>
<body>

    <h2>Neraca Lajur</h2>
    <div class="periode">
        <?php if (!empty($tgl_awal) && !empty($tgl_akhir)) : ?>
            Periode : <?= date('d F Y', strtotime($tgl_awal)) ?> s/d <?= date('d F Y', strtotime($tgl_akhir)) ?>
        <?php else : ?>
            Periode : <?= date('d F Y', strtotime($tgl_awal ?? '')) ?> s/d <?= date('d F Y', strtotime($tgl_akhir ?? '')) ?>
        <?php endif; ?>
    </div>

    <table cellpadding="2" cellspacing="0" border="1">
        <thead>
            <tr style="background-color: #f0f0f0;">
                <th width="8%" rowspan="2" class="text-center"><b>Kode</b></th>
                <th width="18%" rowspan="2" class="text-center"><b>Keterangan</b></th>
                <th width="14.8%" colspan="2" class="text-center"><b>Neraca Saldo</b></th>
                <th width="14.8%" colspan="2" class="text-center"><b>Penyesuaian</b></th>
                <th width="14.8%" colspan="2" class="text-center"><b>NS Disesuaikan</b></th>
                <th width="14.8%" colspan="2" class="text-center"><b>Laba / Rugi</b></th>
                <th width="14.8%" colspan="2" class="text-center"><b>Neraca</b></th>
            </tr>
            <tr style="background-color: #f7f7f7;">
                <th width="7.4%" class="text-right"><b>Debit</b></th>
                <th width="7.4%" class="text-right"><b>Kredit</b></th>
                <th width="7.4%" class="text-right"><b>Debit</b></th>
                <th width="7.4%" class="text-right"><b>Kredit</b></th>
                <th width="7.4%" class="text-right"><b>Debit</b></th>
                <th width="7.4%" class="text-right"><b>Kredit</b></th>
                <th width="7.4%" class="text-right"><b>Debit</b></th>
                <th width="7.4%" class="text-right"><b>Kredit</b></th>
                <th width="7.4%" class="text-right"><b>Debit</b></th>
                <th width="7.4%" class="text-right"><b>Kredit</b></th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($dtlajur as $row) : ?>
                <tr>
                    <td width="8%" class="text-center"><?= $row->kode_akun3 ?></td>
                    <td width="18%"><?= $row->nama_akun3 ?></td>
                    <td width="7.4%" class="text-right"><?= $row->ns_debet > 0 ? number_format($row->ns_debet) : '0' ?></td>
                    <td width="7.4%" class="text-right"><?= $row->ns_kredit > 0 ? number_format($row->ns_kredit) : '0' ?></td>
                    <td width="7.4%" class="text-right"><?= $row->ajp_debet > 0 ? number_format($row->ajp_debet) : '0' ?></td>
                    <td width="7.4%" class="text-right"><?= $row->ajp_kredit > 0 ? number_format($row->ajp_kredit) : '0' ?></td>
                    <td width="7.4%" class="text-right"><?= $row->nsd_debet > 0 ? number_format($row->nsd_debet) : '0' ?></td>
                    <td width="7.4%" class="text-right"><?= $row->nsd_kredit > 0 ? number_format($row->nsd_kredit) : '0' ?></td>
                    <td width="7.4%" class="text-right"><?= $row->lr_debet > 0 ? number_format($row->lr_debet) : '0' ?></td>
                    <td width="7.4%" class="text-right"><?= $row->lr_kredit > 0 ? number_format($row->lr_kredit) : '0' ?></td>
                    <td width="7.4%" class="text-right"><?= $row->n_debet > 0 ? number_format($row->n_debet) : '0' ?></td>
                    <td width="7.4%" class="text-right"><?= $row->n_kredit > 0 ? number_format($row->n_kredit) : '0' ?></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
        <tfoot>
            <tr style="background-color: #f7f7f7; font-weight: bold;">
                <td colspan="2" class="text-center"><b>TOTAL</b></td>
                <td class="text-right"><b><?= number_format($tot_ns_debet) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ns_kredit) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ajp_debet) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ajp_kredit) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_nsd_debet) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_nsd_kredit) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_lr_debet) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_lr_kredit) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_n_debet) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_n_kredit) ?></b></td>
            </tr>
            <tr style="font-weight: bold;">
                <td colspan="2" class="text-center"><b><?= $laba_bersih >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' ?></b></td>
                <td colspan="6" class="text-center">-</td>
                <td class="text-right"><b><?= $laba_bersih >= 0 ? number_format($laba_bersih) : '0' ?></b></td>
                <td class="text-right"><b><?= $laba_bersih < 0 ? number_format(abs($laba_bersih)) : '0' ?></b></td>
                <td class="text-right"><b><?= $laba_bersih < 0 ? number_format(abs($laba_bersih)) : '0' ?></b></td>
                <td class="text-right"><b><?= $laba_bersih >= 0 ? number_format($laba_bersih) : '0' ?></b></td>
            </tr>
            <tr style="background-color: #f0f0f0; font-weight: bold;">
                <td colspan="2" class="text-center"><b>BALANCE</b></td>
                <td class="text-right"><b><?= number_format($tot_ns_debet) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ns_kredit) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ajp_debet) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_ajp_kredit) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_nsd_debet) ?></b></td>
                <td class="text-right"><b><?= number_format($tot_nsd_kredit) ?></b></td>
                <td class="text-right"><b><?= number_format(max($tot_lr_debet, $tot_lr_kredit)) ?></b></td>
                <td class="text-right"><b><?= number_format(max($tot_lr_debet, $tot_lr_kredit)) ?></b></td>
                <td class="text-right"><b><?= number_format(max($tot_n_debet, $tot_n_kredit)) ?></b></td>
                <td class="text-right"><b><?= number_format(max($tot_n_debet, $tot_n_kredit)) ?></b></td>
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
