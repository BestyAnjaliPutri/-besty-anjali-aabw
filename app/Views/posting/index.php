<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Posting</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <h1>Posting</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Posting</h4>
        <div>
          <?php 
            $printUrl = site_url('posting/cetakposting');
            $params = [];
            if (!empty($kode_akun3)) $params['kode_akun3'] = $kode_akun3;
            if (!empty($tgl_awal)) $params['tgl_awal'] = $tgl_awal;
            if (!empty($tgl_akhir)) $params['tgl_akhir'] = $tgl_akhir;
            if (!empty($params)) $printUrl .= '?' . http_build_query($params);
          ?>
          <a href="<?= $printUrl ?>" target="_blank" class="btn btn-primary btn-sm">
            <i class="fas fa-print"></i> Cetak Posting
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="get" action="<?= site_url('posting') ?>" class="mb-4">
          <div class="row align-items-end">
            <div class="col-md-4">
              <label class="font-weight-bold">Filter Akun (Opsional)</label>
              <select name="kode_akun3" class="form-control">
                <option value="">- Semua Akun -</option>
                <?php foreach ($dtakun3 as $akun) : 
                  $ak = (object)$akun;
                ?>
                  <option value="<?= $ak->kode_akun3 ?>" <?= ($kode_akun3 == $ak->kode_akun3) ? 'selected' : '' ?>>
                    <?= $ak->kode_akun3 ?> | <?= $ak->nama_akun3 ?? $ak->nama_akun ?? '' ?>
                  </option>
                <?php endforeach; ?>
              </select>
            </div>
            <div class="col-md-3">
              <label class="font-weight-bold">Tanggal Awal</label>
              <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal ?? '' ?>">
            </div>
            <div class="col-md-3">
              <label class="font-weight-bold">Tanggal Akhir</label>
              <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir ?? '' ?>">
            </div>
            <div class="col-md-2 mt-3 mt-md-0">
              <button type="submit" class="btn btn-primary btn-block">
                <i class="fas fa-search"></i> Cari
              </button>
            </div>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-striped table-md">
            <thead>
              <tr style="background-color: #f4f6f9;">
                <th style="width: 12%">Tanggal</th>
                <th style="width: 10%">Kode Akun</th>
                <th style="width: 30%">Keterangan</th>
                <th class="text-right" style="width: 12%">Debit</th>
                <th class="text-right" style="width: 12%">Kredit</th>
                <th class="text-right" style="width: 12%">Saldo Debit</th>
                <th class="text-right" style="width: 12%">Saldo Kredit</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($dtposting)) : ?>
                <tr>
                  <td colspan="7" class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                    Belum ada data transaksi posting.
                  </td>
                </tr>
              <?php else : ?>
                <?php 
                $saldo_d = 0;
                $saldo_k = 0;
                foreach ($dtposting as $key => $value) : 
                    $debet  = $value->debet ?? $value->debit ?? 0;
                    $kredit = $value->kredit ?? 0;
                    $saldo_d = $saldo_d + $debet - $kredit;
                    if ($saldo_d < 0) {
                        $saldo_k = abs($saldo_d);
                        $saldo_d_display = 0;
                    } else {
                        $saldo_k = 0;
                        $saldo_d_display = $saldo_d;
                    }
                ?>
                  <tr>
                    <td><?= $value->tanggal ?></td>
                    <td><?= $value->kode_akun3 ?></td>
                    <td><?= $value->deskripsi ?></td>
                    <td class="text-right"><?= number_format($debet) ?></td>
                    <td class="text-right"><?= number_format($kredit) ?></td>
                    <td class="text-right"><?= number_format($saldo_d_display) ?></td>
                    <td class="text-right"><?= number_format($saldo_k) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
            <?php if (!empty($dtposting)) : ?>
              <tfoot>
                <tr class="font-weight-bold" style="background-color: #f4f6f9;">
                  <td colspan="3" class="text-center">TOTAL MUTASI</td>
                  <td class="text-right"><?= number_format($totDebet) ?></td>
                  <td class="text-right"><?= number_format($totKredit) ?></td>
                  <td class="text-right"><?= ($saldoAkhir >= 0) ? number_format($saldoAkhir) : 0 ?></td>
                  <td class="text-right"><?= ($saldoAkhir < 0) ? number_format(abs($saldoAkhir)) : 0 ?></td>
                </tr>
              </tfoot>
            <?php endif; ?>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>
<?= $this->endSection() ?>
