<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cetak Neraca Saldo</title>
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <style>
    body {
      font-family: Arial, sans-serif;
      color: #000;
      background-color: #fff;
      padding: 20px;
    }
    .header-kop {
      text-align: center;
      border-bottom: 3px double #000;
      padding-bottom: 12px;
      margin-bottom: 20px;
    }
    .header-kop h3 {
      margin: 0;
      font-size: 20px;
      font-weight: bold;
      text-transform: uppercase;
    }
    .header-kop h4 {
      margin: 4px 0;
      font-size: 16px;
      font-weight: bold;
    }
    .header-kop p {
      margin: 0;
      font-size: 12px;
      color: #444;
    }
    table {
      width: 100%;
      border-collapse: collapse;
      font-size: 13px;
    }
    table th, table td {
      border: 1px solid #000 !important;
      padding: 6px 8px;
    }
    .no-print {
      margin-bottom: 15px;
    }
    @media print {
      .no-print {
        display: none;
      }
      body {
        padding: 0;
      }
    }
  </style>
</head>
<body>

  <div class="no-print d-flex justify-content-between align-items-center">
    <button onclick="window.print()" class="btn btn-primary btn-sm">
      <i class="fas fa-print"></i> Cetak / Print Sekarang
    </button>
    <button onclick="window.close()" class="btn btn-secondary btn-sm">
      Tutup Halaman
    </button>
  </div>

  <div class="header-kop">
    <h3>SIA AKN SV-IPB</h3>
    <h4>NERACA SALDO</h4>
    <p>
      <?php if (!empty($tgl_awal) && !empty($tgl_akhir)) : ?>
        Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?>
      <?php else : ?>
        Semua Periode Transaksi
      <?php endif; ?>
    </p>
  </div>

  <table>
    <thead>
      <tr class="text-center" style="background-color: #f0f0f0;">
        <th style="width: 5%">No</th>
        <th style="width: 15%">Kode Akun</th>
        <th style="width: 44%">Nama Akun</th>
        <th style="width: 18%">Debit (Rp)</th>
        <th style="width: 18%">Kredit (Rp)</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($dtneraca)) : ?>
        <tr>
          <td colspan="5" class="text-center py-3">Tidak ada data transaksi pada periode ini.</td>
        </tr>
      <?php else : ?>
        <?php foreach ($dtneraca as $key => $row) : ?>
          <tr>
            <td class="text-center"><?= $key + 1 ?></td>
            <td class="text-center"><?= $row->kode_akun3 ?></td>
            <td><?= $row->nama_akun3 ?></td>
            <td class="text-right"><?= $row->debet > 0 ? number_format($row->debet) : '-' ?></td>
            <td class="text-right"><?= $row->kredit > 0 ? number_format($row->kredit) : '-' ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr style="background-color: #f0f0f0; font-weight: bold;">
        <td colspan="3" class="text-center">TOTAL</td>
        <td class="text-right">Rp <?= number_format($totDebet) ?></td>
        <td class="text-right">Rp <?= number_format($totKredit) ?></td>
      </tr>
    </tfoot>
  </table>

  <!-- Tanda Tangan -->
  <div style="margin-top: 40px; display: flex; justify-content: space-between; padding: 0 40px;">
    <div style="text-align: center;">
      <p>Mengetahui,<br><strong>Pimpinan Perusahaan</strong></p>
      <br><br><br>
      <p>( ________________________ )</p>
    </div>
    <div style="text-align: center;">
      <p>Bogor, <?= date('d F Y') ?><br><strong>Bagian Keuangan</strong></p>
      <br><br><br>
      <p>( ________________________ )</p>
    </div>
  </div>

</body>
</html>
