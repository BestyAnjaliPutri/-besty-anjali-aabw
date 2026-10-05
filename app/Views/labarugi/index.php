<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Laporan Laba Rugi</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <h1>Laporan Laba Rugi</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Laporan Laba Rugi (Income Statement)</h4>
        <div>
          <?php 
            $pdfUrl = site_url('labarugi/labarugipdf');
            $params = [];
            if (!empty($tgl_awal)) $params['tgl_awal'] = $tgl_awal;
            if (!empty($tgl_akhir)) $params['tgl_akhir'] = $tgl_akhir;
            if (!empty($params)) $pdfUrl .= '?' . http_build_query($params);
          ?>
          <a href="<?= $pdfUrl ?>" target="_blank" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Cetak Laba Rugi (PDF)
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="get" action="<?= site_url('labarugi') ?>" class="mb-4">
          <div class="row align-items-end">
            <div class="col-md-4">
              <label class="font-weight-bold">Tanggal Awal</label>
              <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal ?? '' ?>">
            </div>
            <div class="col-md-4">
              <label class="font-weight-bold">Tanggal Akhir</label>
              <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir ?? '' ?>">
            </div>
            <div class="col-md-4 mt-3 mt-md-0 d-flex">
              <button type="submit" class="btn btn-primary mr-2 flex-grow-1">
                <i class="fas fa-search"></i> Cari
              </button>
              <a href="<?= site_url('labarugi') ?>" class="btn btn-secondary">
                Reset
              </a>
            </div>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-bordered table-md">
            <!-- 1. PENDAPATAN -->
            <thead class="thead-light">
              <tr>
                <th colspan="2" class="font-weight-bold text-dark">PENDAPATAN USAHA</th>
                <th style="width: 25%" class="text-right font-weight-bold text-dark">JUMLAH (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($pendapatan)) : ?>
                <tr>
                  <td colspan="3" class="text-muted text-center">Tidak ada data pendapatan pada periode ini.</td>
                </tr>
              <?php else : ?>
                <?php foreach ($pendapatan as $p) : ?>
                  <tr>
                    <td style="width: 15%"><?= $p->kode_akun3 ?></td>
                    <td><?= $p->nama_akun3 ?></td>
                    <td class="text-right"><?= number_format($p->jumlah) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              <tr class="font-weight-bold table-active">
                <td colspan="2">TOTAL PENDAPATAN</td>
                <td class="text-right text-success">Rp <?= number_format($totPendapatan) ?></td>
              </tr>
            </tbody>

            <!-- 2. BEBAN -->
            <thead class="thead-light">
              <tr>
                <th colspan="2" class="font-weight-bold text-dark pt-4">BEBAN USAHA</th>
                <th class="text-right font-weight-bold text-dark pt-4">JUMLAH (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($beban)) : ?>
                <tr>
                  <td colspan="3" class="text-muted text-center">Tidak ada data beban pada periode ini.</td>
                </tr>
              <?php else : ?>
                <?php foreach ($beban as $b) : ?>
                  <tr>
                    <td><?= $b->kode_akun3 ?></td>
                    <td><?= $b->nama_akun3 ?></td>
                    <td class="text-right"><?= number_format($b->jumlah) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
              <tr class="font-weight-bold table-active">
                <td colspan="2">TOTAL BEBAN</td>
                <td class="text-right text-danger">Rp <?= number_format($totBeban) ?></td>
              </tr>
            </tbody>

            <!-- 3. LABA / RUGI BERSIH -->
            <tfoot>
              <tr class="font-weight-bold" style="background-color: <?= $labaBersih >= 0 ? '#d4edda' : '#f8d7da' ?>; font-size: 15px;">
                <td colspan="2" class="text-uppercase">
                  <?= $labaBersih >= 0 ? 'LABA BERSIH USAHA' : 'RUGI BERSIH USAHA' ?>
                  <span class="badge badge-<?= $labaBersih >= 0 ? 'success' : 'danger' ?> ml-2">
                    <?= $labaBersih >= 0 ? 'SURPLUS' : 'DEFISIT' ?>
                  </span>
                </td>
                <td class="text-right font-weight-bold" style="color: <?= $labaBersih >= 0 ? '#155724' : '#721c24' ?>;">
                  Rp <?= number_format(abs($labaBersih)) ?>
                </td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>
<?= $this->endSection() ?>
