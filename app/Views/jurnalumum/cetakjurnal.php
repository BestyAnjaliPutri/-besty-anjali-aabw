<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Jurnal Umum - PERUSAHAAN AKN-IPB</title>
  <style>
    @page {
      size: A4 portrait;
      margin: 15mm 15mm 15mm 15mm;
    }
    body {
      font-family: 'Times New Roman', Times, serif;
      color: #000;
      background-color: #fff;
      margin: 0;
      padding: 10px 20px;
      font-size: 10pt;
    }
    .header-kop {
      text-align: center;
      margin-bottom: 15px;
    }
    .header-kop .company {
      font-size: 14pt;
      font-weight: bold;
      letter-spacing: 0.5px;
    }
    .header-kop .title {
      font-size: 13pt;
      font-weight: bold;
      margin: 2px 0;
    }
    .header-kop .period {
      font-size: 11pt;
      font-weight: bold;
    }
    .sub-info {
      text-align: right;
      font-size: 10pt;
      margin-bottom: 4px;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 9.5pt;
    }
    table th, table td {
      border: 1px solid #000;
      padding: 5px 6px;
    }
    table th {
      font-weight: bold;
      text-align: center;
      background-color: #fff;
    }
    .text-center { text-align: center; }
    .text-right { text-align: right; }
    .text-left { text-align: left; }
    .indent-kredit {
      padding-left: 28px;
    }
    .no-print {
      margin-bottom: 15px;
      display: flex;
      justify-content: space-between;
    }
    .btn {
      padding: 6px 14px;
      font-size: 9pt;
      cursor: pointer;
      border: 1px solid #333;
      background: #f0f0f0;
      border-radius: 4px;
    }
    @media print {
      .no-print {
        display: none !important;
      }
      body {
        padding: 0;
      }
    }
  </style>
</head>
<body>

  <div class="no-print">
    <button onclick="window.print()" class="btn">
      🖨️ Cetak / Print Sekarang
    </button>
    <button onclick="window.close()" class="btn">
      Tutup Halaman
    </button>
  </div>

  <div class="header-kop">
    <div class="company">PERUSAHAAN AKN-IPB</div>
    <div class="title">JURNAL UMUM</div>
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

  <div class="sub-info">
    J1 (Rp)
  </div>

  <table>
    <thead>
      <tr>
        <th style="width: 14%;">Tanggal</th>
        <th style="width: 48%;">Akun</th>
        <th style="width: 10%;">Ref.</th>
        <th style="width: 14%;">Debit</th>
        <th style="width: 14%;">Kredit</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($dtjurnal)) : ?>
        <tr>
          <td colspan="5" class="text-center" style="padding: 15px;">Tidak ada data transaksi jurnal umum.</td>
        </tr>
      <?php else : ?>
        <?php 
        $prevId = null;
        foreach ($dtjurnal as $row) : 
            $valDebet  = $row->debet ?? $row->debit ?? 0;
            $valKredit = $row->kredit ?? 0;
            $isFirstInTx = ($prevId !== $row->id_transaksi);
            $prevId = $row->id_transaksi;
        ?>
          <tr>
            <td class="text-center">
              <?= $isFirstInTx ? date('d/m/Y', strtotime($row->tanggal)) : '' ?>
            </td>
            <td>
              <?php if ($valDebet > 0) : ?>
                <strong><?= esc($row->nama_akun3) ?></strong>
              <?php else : ?>
                <span class="indent-kredit"><?= esc($row->nama_akun3) ?></span>
              <?php endif; ?>
            </td>
            <td class="text-center"><?= esc($row->kode_akun3) ?></td>
            <td class="text-right">
              <?= $valDebet > 0 ? number_format($valDebet, 0, ',', '.') : '-' ?>
            </td>
            <td class="text-right">
              <?= $valKredit > 0 ? number_format($valKredit, 0, ',', '.') : '-' ?>
            </td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr style="font-weight: bold;">
        <td colspan="3" class="text-center">TOTAL</td>
        <td class="text-right"><?= number_format($totDebet, 0, ',', '.') ?></td>
        <td class="text-right"><?= number_format($totKredit, 0, ',', '.') ?></td>
      </tr>
    </tfoot>
  </table>

</body>
</html>