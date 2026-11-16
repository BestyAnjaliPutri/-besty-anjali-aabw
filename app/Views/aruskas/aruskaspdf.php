<!DOCTYPE html>
<html>
<head>
    <title>Laporan Arus Kas - PERUSAHAAN AKN-IPB</title>
    <style>
        body {
            font-family: 'times', serif;
            font-size: 9pt;
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
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 9pt;
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
        .text-right { text-align: right; }
        .text-center { text-align: center; }
        .text-left { text-align: left; }
    </style>
</head>
<body>

    <div class="header-kop">
        <div class="company">PERUSAHAAN AKN-IPB</div>
        <div class="title">LAPORAN ARUS KAS</div>
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

    <table cellpadding="3" cellspacing="0">
        <tbody>
            <!-- 1. ARUS KAS DARI AKTIVITAS OPERASI -->
            <tr class="border-top border-bottom">
                <td colspan="2"><b>ARUS KAS DARI AKTIVITAS OPERASI</b></td>
            </tr>
            <tr>
                <td colspan="2"><b><u>Penerimaan Kas:</u></b></td>
            </tr>
            <?php if (empty($operasiMasuk)) : ?>
                <tr>
                    <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Tidak ada penerimaan operasi</td>
                    <td width="30%" class="text-right">-</td>
                </tr>
            <?php else : ?>
                <?php foreach ($operasiMasuk as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($ket) ?></td>
                        <td width="30%" class="text-right"><?= number_format($nom, 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr>
                <td colspan="2"><b><u>Pengeluaran Kas:</u></b></td>
            </tr>
            <?php if (empty($operasiKeluar)) : ?>
                <tr>
                    <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Tidak ada pengeluaran operasi</td>
                    <td width="30%" class="text-right">-</td>
                </tr>
            <?php else : ?>
                <?php foreach ($operasiKeluar as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($ket) ?></td>
                        <td width="30%" class="text-right">(<?= number_format($nom, 0, ',', '.') ?>)</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr class="border-top">
                <td width="70%"><b>Arus Kas Bersih dari Aktivitas Operasi</b></td>
                <td width="30%" class="text-right"><b><?= number_format($netOperasi, 0, ',', '.') ?></b></td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <!-- 2. ARUS KAS DARI AKTIVITAS INVESTASI -->
            <tr class="border-top border-bottom">
                <td colspan="2"><b>ARUS KAS DARI AKTIVITAS INVESTASI</b></td>
            </tr>
            <?php if (empty($investasiMasuk) && empty($investasiKeluar)) : ?>
                <tr>
                    <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Tidak ada mutasi kas investasi periode ini</td>
                    <td width="30%" class="text-right">-</td>
                </tr>
            <?php else : ?>
                <?php foreach ($investasiMasuk as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($ket) ?></td>
                        <td width="30%" class="text-right"><?= number_format($nom, 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php foreach ($investasiKeluar as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($ket) ?></td>
                        <td width="30%" class="text-right">(<?= number_format($nom, 0, ',', '.') ?>)</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr class="border-top">
                <td width="70%"><b>Arus Kas Bersih dari Aktivitas Investasi</b></td>
                <td width="30%" class="text-right"><b><?= number_format($netInvestasi, 0, ',', '.') ?></b></td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <!-- 3. ARUS KAS DARI AKTIVITAS PENDANAAN -->
            <tr class="border-top border-bottom">
                <td colspan="2"><b>ARUS KAS DARI AKTIVITAS PENDANAAN</b></td>
            </tr>
            <?php if (empty($pendanaanMasuk) && empty($pendanaanKeluar)) : ?>
                <tr>
                    <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;Tidak ada mutasi kas pendanaan periode ini</td>
                    <td width="30%" class="text-right">-</td>
                </tr>
            <?php else : ?>
                <?php foreach ($pendanaanMasuk as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($ket) ?></td>
                        <td width="30%" class="text-right"><?= number_format($nom, 0, ',', '.') ?></td>
                    </tr>
                <?php endforeach; ?>
                <?php foreach ($pendanaanKeluar as $ket => $nom) : ?>
                    <tr>
                        <td width="70%">&nbsp;&nbsp;&nbsp;&nbsp;<?= esc($ket) ?></td>
                        <td width="30%" class="text-right">(<?= number_format($nom, 0, ',', '.') ?>)</td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>

            <tr class="border-top">
                <td width="70%"><b>Arus Kas Bersih dari Aktivitas Pendanaan</b></td>
                <td width="30%" class="text-right"><b><?= number_format($netPendanaan, 0, ',', '.') ?></b></td>
            </tr>

            <tr><td colspan="2">&nbsp;</td></tr>

            <!-- REKONSILIASI KAS -->
            <tr class="border-top">
                <td width="70%"><b>Kenaikan (Penurunan) Bersih Kas</b></td>
                <td width="30%" class="text-right"><b><?= number_format($kenaikanKas, 0, ',', '.') ?></b></td>
            </tr>
            <tr>
                <td width="70%">Saldo Kas Awal Periode</td>
                <td width="30%" class="text-right"><?= number_format($saldoAwal, 0, ',', '.') ?></td>
            </tr>
            <tr class="border-top border-double">
                <td width="70%"><b>SALDO KAS AKHIR PERIODE</b></td>
                <td width="30%" class="text-right"><b>Rp <?= number_format($saldoAkhir, 0, ',', '.') ?></b></td>
            </tr>
        </tbody>
    </table>

</body>
</html>