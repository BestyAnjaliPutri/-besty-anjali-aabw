<!DOCTYPE html>
<html>
<head>
    <title>Laporan Arus Kas PDF</title>
    <style>
        body {
            font-family: helvetica, sans-serif;
            font-size: 8.5pt;
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
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 8.5pt;
        }
        td {
            padding: 4px 3px;
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
        .section-header {
            background-color: #f2f2f2;
            font-weight: bold;
        }
        .signature {
            margin-top: 25px;
            font-size: 8.5pt;
        }
    </style>
</head>
<body>

    <h2>Laporan Arus Kas</h2>
    <div class="periode">
        <?php if (!empty($tgl_awal) && !empty($tgl_akhir)) : ?>
            Periode : <?= date('d F Y', strtotime($tgl_awal)) ?> s/d <?= date('d F Y', strtotime($tgl_akhir)) ?>
        <?php else : ?>
            Periode : 01 Desember 2025 s/d 31 Desember 2025
        <?php endif; ?>
    </div>

    <table cellpadding="3" cellspacing="0">
        <tbody>
            <!-- 1. ARUS KAS DARI AKTIVITAS OPERASI -->
            <tr class="section-header">
                <td colspan="2"><b>ARUS KAS DARI AKTIVITAS OPERASI</b></td>
            </tr>
            <tr>
                <td colspan="2"><b><u>Penerimaan Kas:</u></b></td>
            </tr>
            <?php if (empty($operasiMasuk)) : ?>
                <tr>
                    <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Tidak ada penerimaan operasi</td>
                    <td width="30%" class="text-right">0</td>
                </tr>
            <?php else : ?>
                <?php foreach ($operasiMasuk as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $ket ?></td>
                        <td width="30%" class="text-right"><?= number_format($nom) ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr>
                <td colspan="2"><b><u>Pengeluaran Kas:</u></b></td>
            </tr>
            <?php if (empty($operasiKeluar)) : ?>
                <tr>
                    <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Tidak ada pengeluaran operasi</td>
                    <td width="30%" class="text-right">0</td>
                </tr>
            <?php else : ?>
                <?php foreach ($operasiKeluar as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $ket ?></td>
                        <td width="30%" class="text-right">(<?= number_format($nom) ?>)</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr class="border-top">
                <td width="70%"><b>Arus Kas Bersih dari Aktivitas Operasi</b></td>
                <td width="30%" class="text-right"><b><?= number_format($netOperasi) ?></b></td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <!-- 2. ARUS KAS DARI AKTIVITAS INVESTASI -->
            <tr class="section-header">
                <td colspan="2"><b>ARUS KAS DARI AKTIVITAS INVESTASI</b></td>
            </tr>
            <?php if (empty($investasiMasuk) && empty($investasiKeluar)) : ?>
                <tr>
                    <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Tidak ada mutasi kas investasi periode ini</td>
                    <td width="30%" class="text-right">0</td>
                </tr>
            <?php else : ?>
                <?php foreach ($investasiMasuk as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $ket ?></td>
                        <td width="30%" class="text-right"><?= number_format($nom) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php foreach ($investasiKeluar as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $ket ?></td>
                        <td width="30%" class="text-right">(<?= number_format($nom) ?>)</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr class="border-top">
                <td width="70%"><b>Arus Kas Bersih dari Aktivitas Investasi</b></td>
                <td width="30%" class="text-right"><b><?= number_format($netInvestasi) ?></b></td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <!-- 3. ARUS KAS DARI AKTIVITAS PENDANAAN -->
            <tr class="section-header">
                <td colspan="2"><b>ARUS KAS DARI AKTIVITAS PENDANAAN</b></td>
            </tr>
            <?php if (empty($pendanaanMasuk) && empty($pendanaanKeluar)) : ?>
                <tr>
                    <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Tidak ada mutasi kas pendanaan periode ini</td>
                    <td width="30%" class="text-right">0</td>
                </tr>
            <?php else : ?>
                <?php foreach ($pendanaanMasuk as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $ket ?></td>
                        <td width="30%" class="text-right"><?= number_format($nom) ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php foreach ($pendanaanKeluar as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= $ket ?></td>
                        <td width="30%" class="text-right">(<?= number_format($nom) ?>)</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr class="border-top">
                <td width="70%"><b>Arus Kas Bersih dari Aktivitas Pendanaan</b></td>
                <td width="30%" class="text-right"><b><?= number_format($netPendanaan) ?></b></td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <!-- REKONSILIASI KAS -->
            <tr class="border-top">
                <td width="70%"><b>Kenaikan (Penurunan) Bersih Kas</b></td>
                <td width="30%" class="text-right"><b><?= number_format($kenaikanKas) ?></b></td>
            </tr>
            <tr>
                <td width="70%">Saldo Kas Awal Periode</td>
                <td width="30%" class="text-right"><?= number_format($saldoAwal) ?></td>
            </tr>
            <tr class="border-top border-double" style="background-color: #f7f7f7;">
                <td width="70%"><b>SALDO KAS AKHIR PERIODE</b></td>
                <td width="30%" class="text-right"><b>Rp <?= number_format($saldoAkhir) ?></b></td>
            </tr>
        </tbody>
    </table>

    <div class="signature">
        <p>
            Bogor, 31 Desember 2025<br>
            Pimpinan AKN<br><br><br><br>
        </p>
    </div>

</body>
</html>
