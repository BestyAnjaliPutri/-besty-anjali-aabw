<!DOCTYPE html>
<html>
<head>
    <title>Buku Besar - PERUSAHAAN AKN-IPB</title>
    <style>
        body {
            font-family: 'times', serif;
            font-size: 8.5pt;
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
        table.meta-table {
            width: 100%;
            margin-top: 10px;
            margin-bottom: 3px;
        }
        table.meta-table td {
            font-size: 9.5pt;
            font-weight: bold;
        }
        table.data-table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
        }
        table.data-table th, table.data-table td {
            border: 0.5px solid #000;
            padding: 3px 4px;
        }
        table.data-table th {
            font-weight: bold;
            text-align: center;
            background-color: #f5f5f5;
        }
        .text-center { text-align: center; }
        .text-right { text-align: right; }
        .text-left { text-align: left; }
    </style>
</head>
<body>

    <div class="header-kop">
        <div class="company">PERUSAHAAN AKN-IPB</div>
        <div class="title">BUKU BESAR</div>
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

    <?php foreach ($bukuBesar as $acc) : ?>
        <table class="meta-table" cellpadding="0" cellspacing="0" border="0">
            <tr>
                <td width="55%" align="left">
                    Nama Akun: <?= esc($acc['nama_akun3']) ?>
                </td>
                <td width="45%" align="right">
                    No : <?= esc($acc['kode_akun3']) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Rp,-)
                </td>
            </tr>
        </table>

        <table class="data-table" border="0.5" cellpadding="3" cellspacing="0" width="100%">
            <thead>
                <tr style="background-color: #f7f7f7;">
                    <th width="13%" rowspan="2" align="center"><b>Tanggal</b></th>
                    <th width="31%" rowspan="2" align="center"><b>Keterangan</b></th>
                    <th width="8%" rowspan="2" align="center"><b>Ref</b></th>
                    <th width="12%" rowspan="2" align="center"><b>Debit</b></th>
                    <th width="12%" rowspan="2" align="center"><b>Kredit</b></th>
                    <th width="24%" colspan="2" align="center"><b>Saldo</b></th>
                </tr>
                <tr style="background-color: #f7f7f7;">
                    <th width="12%" align="center"><b>Debit</b></th>
                    <th width="12%" align="center"><b>Kredit</b></th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($acc['mutasi'])) : ?>
                    <tr>
                        <td width="13%" align="center">-</td>
                        <td width="31%" align="left" style="font-style: italic; color: #555;">Saldo Awal</td>
                        <td width="8%" align="center">-</td>
                        <td width="12%" align="right">-</td>
                        <td width="12%" align="right">-</td>
                        <td width="12%" align="right">-</td>
                        <td width="12%" align="right">-</td>
                    </tr>
                <?php else : ?>
                    <?php foreach ($acc['mutasi'] as $row) : 
                        $valDebet  = floatval($row->debet ?? $row->debit ?? 0);
                        $valKredit = floatval($row->kredit ?? 0);
                    ?>
                        <tr>
                            <td width="13%" align="center"><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                            <td width="31%" align="left"><?= esc($row->deskripsi ?? 'Transaksi') ?></td>
                            <td width="8%" align="center"><?= esc($row->kwitansi ?? 'J1') ?></td>
                            <td width="12%" align="right"><?= $valDebet > 0 ? number_format($valDebet, 0, ',', '.') : '-' ?></td>
                            <td width="12%" align="right"><?= $valKredit > 0 ? number_format($valKredit, 0, ',', '.') : '-' ?></td>
                            <td width="12%" align="right"><?= ($row->saldo_debet ?? 0) > 0 ? number_format($row->saldo_debet, 0, ',', '.') : '-' ?></td>
                            <td width="12%" align="right"><?= ($row->saldo_kredit ?? 0) > 0 ? number_format($row->saldo_kredit, 0, ',', '.') : '-' ?></td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
        <br/>
    <?php endforeach; ?>

</body>
</html>
