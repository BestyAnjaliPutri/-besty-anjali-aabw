<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Neraca Saldo - PERUSAHAAN AKN-IPB</title>
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
      margin-bottom: 12px;
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
    .currency {
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

  <table>
    <thead>
      <tr>
        <th rowspan="2" style="width: 8%;">No</th>
        <th rowspan="2" style="width: 52%;">Akun</th>
        <th colspan="2" style="width: 40%;">Saldo</th>
      </tr>
      <tr>
        <th style="width: 20%;">Debit</th>
        <th style="width: 20%;">Kredit</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($dtneraca)) : ?>
        <tr>
          <td colspan="4" class="text-center" style="padding: 15px;">Tidak ada data transaksi pada periode ini.</td>
        </tr>
      <?php else : ?>
        <?php foreach ($dtneraca as $key => $row) : ?>
          <tr>
            <td class="text-center"><?= $key + 1 ?></td>
            <td><?= esc($row->nama_akun3) ?></td>
            <td class="text-right"><?= $row->debet > 0 ? number_format($row->debet, 0, ',', '.') : '-' ?></td>
            <td class="text-right"><?= $row->kredit > 0 ? number_format($row->kredit, 0, ',', '.') : '-' ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr style="font-weight: bold;">
        <td colspan="2" class="text-center">TOTAL</td>
        <td class="text-right"><?= number_format($totDebet, 0, ',', '.') ?></td>
        <td class="text-right"><?= number_format($totKredit, 0, ',', '.') ?></td>
      </tr>
    </tfoot>
  </table>

</body>
</html>