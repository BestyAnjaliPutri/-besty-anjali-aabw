<!DOCTYPE html>
<html>
<head>
    <title>Laporan Neraca PDF</title>
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
            font-size: 8.5pt;
            margin-top: 0;
            margin-bottom: 15px;
        }
        table.outer {
            width: 100%;
            border-collapse: collapse;
        }
        table.inner {
            width: 100%;
            border-collapse: collapse;
            font-size: 8pt;
        }
        table.inner td {
            padding: 3px 2px;
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
        .text-right {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .header-section {
            background-color: #f0f0f0;
            font-weight: bold;
            padding: 3px;
        }
        .signature {
            margin-top: 25px;
            font-size: 8.5pt;
        }
    </style>
</head>
<body>

    <h2>Laporan Posisi Keuangan (Neraca)</h2>
    <div class="periode">
        <?php if (!empty($tgl_awal) && !empty($tgl_akhir)) : ?>
            Periode : <?= date('d F Y', strtotime($tgl_awal)) ?> s/d <?= date('d F Y', strtotime($tgl_akhir)) ?>
        <?php else : ?>
            Periode : Per 31 Desember 2025
        <?php endif; ?>
    </div>

    <table class="outer" cellpadding="0" cellspacing="0">
        <tr>
            <!-- SISI KIRI: AKTIVA -->
            <td width="49%" valign="top">
                <table class="inner" cellpadding="3" cellspacing="0">
                    <tr class="header-section">
                        <td colspan="2"><b>AKTIVA (ASSETS)</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><u>Aktiva Lancar:</u></b></td>
                    </tr>
                    <?php foreach ($aktivaLancar as $al) : ?>
                        <tr>
                            <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $al['nama_akun3'] ?></td>
                            <td width="35%" class="text-right"><?= number_format($al['saldo'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="border-top">
                        <td width="65%"><b>Total Aktiva Lancar</b></td>
                        <td width="35%" class="text-right"><b><?= number_format($totAktivaLancar, 0, ',', '.') ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><u>Aktiva Tetap:</u></b></td>
                    </tr>
                    <?php foreach ($aktivaTetap as $at) : ?>
                        <tr>
                            <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $at['nama_akun3'] ?></td>
                            <td width="35%" class="text-right">
                                <?= $at['is_contra'] ? '(' . number_format(abs($at['saldo']), 0, ',', '.') . ')' : number_format($at['saldo'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="border-top">
                        <td width="65%"><b>Total Aktiva Tetap</b></td>
                        <td width="35%" class="text-right"><b><?= number_format($totAktivaTetap, 0, ',', '.') ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr class="border-top border-double" style="background-color: #f7f7f7;">
                        <td width="65%"><b>TOTAL AKTIVA</b></td>
                        <td width="35%" class="text-right"><b>Rp <?= number_format($totAktiva, 0, ',', '.') ?></b></td>
                    </tr>
                </table>
            </td>

            <!-- PEMISAH -->
            <td width="2%">&nbsp;</td>

            <!-- SISI KANAN: PASIVA -->
            <td width="49%" valign="top">
                <table class="inner" cellpadding="3" cellspacing="0">
                    <tr class="header-section">
                        <td colspan="2"><b>KEWAJIBAN & EKUITAS</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><u>Kewajiban (Utang Lancar):</u></b></td>
                    </tr>
                    <?php foreach ($kewajiban as $kw) : ?>
                        <tr>
                            <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $kw['nama_akun3'] ?></td>
                            <td width="35%" class="text-right"><?= number_format($kw['saldo'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="border-top">
                        <td width="65%"><b>Total Kewajiban</b></td>
                        <td width="35%" class="text-right"><b><?= number_format($totKewajiban, 0, ',', '.') ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><u>Ekuitas (Modal):</u></b></td>
                    </tr>
                    <tr>
                        <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;Modal Pemilik</td>
                        <td width="35%" class="text-right"><?= number_format($modalPemilik, 0, ',', '.') ?></td>
                    </tr>
                    <tr>
                        <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;Laba Ditahan</td>
                        <td width="35%" class="text-right"><?= number_format($labaDitahan, 0, ',', '.') ?></td>
                    </tr>
                    <tr class="border-top">
                        <td width="65%"><b>Total Ekuitas</b></td>
                        <td width="35%" class="text-right"><b><?= number_format($totEkuitas, 0, ',', '.') ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr class="border-top border-double" style="background-color: #f7f7f7;">
                        <td width="65%"><b>TOTAL PASIVA</b></td>
                        <td width="35%" class="text-right"><b>Rp <?= number_format($totPasiva, 0, ',', '.') ?></b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

    <div class="signature">
        <p>
            Bogor, 31 Desember 2025<br>
            Pimpinan AKN<br><br><br><br>
        </p>
    </div>

</body>
</html>
