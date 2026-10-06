<?php 
  $sel = !empty($selectedAkun) ? (object)$selectedAkun : null;
  $namaAkunCetak = $sel ? ($sel->nama_akun3 ?? $sel->nama_akun ?? '') : '';
  $kodeAkunCetak = $sel ? ($sel->kode_akun3 ?? '') : '';
?>
<!DOCTYPE html>
<html lang="id">
<head>
  <meta charset="UTF-8">
  <title>Cetak Buku Besar <?= !empty($namaAkunCetak) ? '- ' . $namaAkunCetak . ' (' . $kodeAkunCetak . ')' : '' ?></title>
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
    <h4>BUKU BESAR (POSTING)</h4>
    <p>
      <?php if (!empty($tgl_awal) && !empty($tgl_akhir)) : ?>
        Periode: <?= date('d/m/Y', strtotime($tgl_awal)) ?> s/d <?= date('d/m/Y', strtotime($tgl_akhir)) ?>
      <?php else : ?>
        Semua Periode Transaksi
      <?php endif; ?>
    </p>
  </div>

  <?php if (!empty($namaAkunCetak)) : ?>
    <div class="row mb-3" style="font-size: 14px;">
      <div class="col-6">
        <strong>Nama Akun:</strong> <?= $namaAkunCetak ?>
      </div>
      <div class="col-6 text-right">
        <strong>Kode Akun:</strong> <?= $kodeAkunCetak ?>
        <span class="ml-3"><strong>Saldo Normal:</strong> <span style="text-transform: uppercase;"><?= $posisiNormal ?></span></span>
      </div>
    </div>
  <?php endif; ?>

  <table>
    <thead>
      <tr class="text-center" style="background-color: #f0f0f0;">
        <th rowspan="2" style="width: 12%">Tanggal</th>
        <?php if (empty($namaAkunCetak)) : ?>
          <th rowspan="2" style="width: 10%">Kode Akun</th>
        <?php endif; ?>
        <th rowspan="2" style="width: 30%">Keterangan</th>
        <th rowspan="2" style="width: 10%">Ref</th>
        <th rowspan="2" style="width: 12%">Debit (Rp)</th>
        <th rowspan="2" style="width: 12%">Kredit (Rp)</th>
        <th colspan="2" style="width: 24%">Saldo (Rp)</th>
      </tr>
      <tr class="text-center" style="background-color: #f0f0f0;">
        <th style="width: 12%">Debit</th>
        <th style="width: 12%">Kredit</th>
      </tr>
    </thead>
    <tbody>
      <?php if (empty($dtposting)) : ?>
        <tr>
          <td colspan="<?= empty($namaAkunCetak) ? 8 : 7 ?>" class="text-center py-3">Tidak ada data transaksi pada periode ini.</td>
        </tr>
      <?php else : ?>
        <?php foreach ($dtposting as $row) : 
            $valDebet  = $row->debet ?? $row->debit ?? 0;
            $valKredit = $row->kredit ?? 0;
        ?>
          <tr>
            <td class="text-center"><?= date('d/m/Y', strtotime($row->tanggal)) ?></td>
            <?php if (empty($namaAkunCetak)) : ?>
              <td class="text-center"><?= $row->kode_akun3 ?></td>
            <?php endif; ?>
            <td><?= $row->deskripsi ?></td>
            <td class="text-center"><?= $row->kwitansi ?></td>
            <td class="text-right"><?= $valDebet > 0 ? number_format($valDebet) : '-' ?></td>
            <td class="text-right"><?= $valKredit > 0 ? number_format($valKredit) : '-' ?></td>
            <td class="text-right"><?= ($row->saldo_debet ?? 0) > 0 ? number_format($row->saldo_debet) : '-' ?></td>
            <td class="text-right"><?= ($row->saldo_kredit ?? 0) > 0 ? number_format($row->saldo_kredit) : '-' ?></td>
          </tr>
        <?php endforeach; ?>
      <?php endif; ?>
    </tbody>
    <tfoot>
      <tr style="background-color: #f0f0f0; font-weight: bold;">
        <td colspan="<?= empty($namaAkunCetak) ? 4 : 3 ?>" class="text-center">TOTAL MUTASI</td>
        <td class="text-right">Rp <?= number_format($totDebet) ?></td>
        <td class="text-right">Rp <?= number_format($totKredit) ?></td>
        <td class="text-right">
          <?= ($saldoAkhir >= 0) ? 'Rp ' . number_format($saldoAkhir) : '-' ?>
        </td>
        <td class="text-right">
          <?= ($saldoAkhir < 0) ? 'Rp ' . number_format(abs($saldoAkhir)) : '-' ?>
        </td>
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
