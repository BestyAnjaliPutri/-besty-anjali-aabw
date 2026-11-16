<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Buku Besar - PERUSAHAAN AKN-IPB</title>
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
      margin-bottom: 18px;
    }
    .header-kop .company {
      font-size: 13pt;
      font-weight: bold;
      letter-spacing: 0.5px;
    }
    .header-kop .title {
      font-size: 12pt;
      font-weight: bold;
      margin: 2px 0;
    }
    .header-kop .period {
      font-size: 11pt;
      font-weight: bold;
    }
    .buku-besar-item {
      margin-bottom: 22px;
      page-break-inside: avoid;
    }
    .account-meta-table {
      width: 100%;
      border-collapse: collapse;
      margin-bottom: 4px;
      font-size: 10pt;
      font-weight: bold;
    }
    .account-meta-table td {
      border: none !important;
      padding: 2px 0;
    }
    table.data-table {
      width: 100%;
      border-collapse: collapse;
      table-layout: fixed;
      font-size: 9.5pt;
    }
    table.data-table th, table.data-table td {
      border: 1px solid #000;
      padding: 4px 6px;
      word-wrap: break-word;
      overflow-wrap: break-word;
    }
    table.data-table th {
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
    <div class="buku-besar-item">
      <table class="account-meta-table">
        <tr>
          <td style="text-align: left; width: 55%; font-weight: bold;">
            Nama Akun: <?= esc($acc['nama_akun3']) ?>
          </td>
          <td style="text-align: right; width: 45%; font-weight: bold;">
            No : <?= esc($acc['kode_akun3']) ?> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; (Rp,-)
          </td>
        </tr>
      </table>

      <table class="data-table">
        <thead>
          <tr>
            <th width="13%" rowspan="2">Tanggal</th>
            <th width="31%" rowspan="2">Keterangan</th>
            <th width="8%" rowspan="2">Ref</th>
            <th width="12%" rowspan="2">Debit</th>
            <th width="12%" rowspan="2">Kredit</th>
            <th width="24%" colspan="2">Saldo</th>
          </tr>
          <tr>
            <th width="12%">Debit</th>
            <th width="12%">Kredit</th>
          </tr>
        </thead>
        <tbody>
          <?php if (empty($acc['mutasi'])) : ?>
            <tr>
              <td width="13%" class="text-center">-</td>
              <td width="31%" style="font-style: italic; color: #555;">Saldo Awal</td>
              <td width="8%" class="text-center">-</td>
              <td width="12%" class="text-right">-</td>
              <td width="12%" class="text-right">-</td>
              <td width="12%" class="text-right">-</td>
              <td width="12%" class="text-right">-</td>
            </tr>
          <?php else : ?>
            <?php foreach ($acc['mutasi'] as $row) : 
                $valDebet  = floatval($row->debet ?? $row->debit ?? 0);
                $valKredit = floatval($row->kredit ?? 0);
            ?>
              <tr>
                <td width="13%" class="text-center"><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
                <td width="31%"><?= esc($row->deskripsi ?? 'Transaksi') ?></td>
                <td width="8%" class="text-center"><?= esc($row->kwitansi ?? 'J1') ?></td>
                <td width="12%" class="text-right"><?= $valDebet > 0 ? number_format($valDebet, 0, ',', '.') : '-' ?></td>
                <td width="12%" class="text-right"><?= $valKredit > 0 ? number_format($valKredit, 0, ',', '.') : '-' ?></td>
                <td width="12%" class="text-right"><?= ($row->saldo_debet ?? 0) > 0 ? number_format($row->saldo_debet, 0, ',', '.') : '-' ?></td>
                <td width="12%" class="text-right"><?= ($row->saldo_kredit ?? 0) > 0 ? number_format($row->saldo_kredit, 0, ',', '.') : '-' ?></td>
              </tr>
            <?php endforeach; ?>
          <?php endif; ?>
        </tbody>
      </table>
    </div>
  <?php endforeach; ?>

</body>
</html>
