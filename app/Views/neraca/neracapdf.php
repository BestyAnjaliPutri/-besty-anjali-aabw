<!DOCTYPE html>
<html>
<head>
    <title>Laporan Posisi Keuangan - PERUSAHAAN AKN-IPB</title>
    <style>
        body {
            font-family: 'times', serif;
            font-size: 8.5pt;
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
        table.outer {
            width: 100%;
            border-collapse: collapse;
        }
        table.inner {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
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
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
    </style>
</head>
<body>

    <div class="header-kop">
        <div class="company">PERUSAHAAN AKN-IPB</div>
        <div class="title">LAPORAN POSISI KEUANGAN</div>
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
        (Rp,-)
    </div>

    <table class="outer" cellpadding="0" cellspacing="0">
        <tr>
            <!-- SISI KIRI: ASET / AKTIVA -->
            <td width="48%" valign="top">
                <table class="inner" cellpadding="3" cellspacing="0">
                    <tr class="border-top border-bottom">
                        <td colspan="2"><b>ASET (AKTIVA)</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><u>Aset Lancar:</u></b></td>
                    </tr>
                    <?php foreach ($aktivaLancar as $al) : ?>
                        <tr>
                            <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($al['nama_akun3']) ?></td>
                            <td width="35%" class="text-right"><?= number_format($al['saldo'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="border-top">
                        <td width="65%"><b>Total Aset Lancar</b></td>
                        <td width="35%" class="text-right"><b><?= number_format($totAktivaLancar, 0, ',', '.') ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><u>Aset Tetap:</u></b></td>
                    </tr>
                    <?php foreach ($aktivaTetap as $at) : ?>
                        <tr>
                            <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($at['nama_akun3']) ?></td>
                            <td width="35%" class="text-right">
                                <?= $at['is_contra'] ? '(' . number_format(abs($at['saldo']), 0, ',', '.') . ')' : number_format($at['saldo'], 0, ',', '.') ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="border-top">
                        <td width="65%"><b>Total Aset Tetap</b></td>
                        <td width="35%" class="text-right"><b><?= number_format($totAktivaTetap, 0, ',', '.') ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr class="border-top border-double">
                        <td width="65%"><b>TOTAL ASET</b></td>
                        <td width="35%" class="text-right"><b>Rp <?= number_format($totAktiva, 0, ',', '.') ?></b></td>
                    </tr>
                </table>
            </td>

            <!-- PEMISAH / GARIS TENGAH -->
            <td width="4%" style="border-right: 0.5px solid #000;">&nbsp;</td>
            <td width="4%">&nbsp;</td>

            <!-- SISI KANAN: LIABILITAS & EKUITAS -->
            <td width="44%" valign="top">
                <table class="inner" cellpadding="3" cellspacing="0">
                    <tr class="border-top border-bottom">
                        <td colspan="2"><b>LIABILITAS & EKUITAS</b></td>
                    </tr>
                    <tr>
                        <td colspan="2"><b><u>Liabilitas (Kewajiban):</u></b></td>
                    </tr>
                    <?php foreach ($kewajiban as $kw) : ?>
                        <tr>
                            <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($kw['nama_akun3']) ?></td>
                            <td width="35%" class="text-right"><?= number_format($kw['saldo'], 0, ',', '.') ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr class="border-top">
                        <td width="65%"><b>Total Liabilitas</b></td>
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
                        <td width="65%">&nbsp;&nbsp;&nbsp;&nbsp;Laba Ditahan / Periode Berjalan</td>
                        <td width="35%" class="text-right"><?= number_format($labaDitahan, 0, ',', '.') ?></td>
                    </tr>
                    <tr class="border-top">
                        <td width="65%"><b>Total Ekuitas</b></td>
                        <td width="35%" class="text-right"><b><?= number_format($totEkuitas, 0, ',', '.') ?></b></td>
                    </tr>
                    <tr>
                        <td colspan="2">&nbsp;</td>
                    </tr>
                    <tr class="border-top border-double">
                        <td width="65%"><b>TOTAL LIABILITAS & EKUITAS</b></td>
                        <td width="35%" class="text-right"><b>Rp <?= number_format($totPasiva, 0, ',', '.') ?></b></td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>

</body>
</html>