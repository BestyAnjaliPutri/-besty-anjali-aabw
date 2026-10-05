<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Laporan Arus Kas</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <h1>Laporan Arus Kas</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Laporan Arus Kas (Statement of Cash Flows)</h4>
        <div>
          <?php 
            $pdfUrl = site_url('aruskas/aruskaspdf');
            $params = [];
            if (!empty($tgl_awal)) $params['tgl_awal'] = $tgl_awal;
            if (!empty($tgl_akhir)) $params['tgl_akhir'] = $tgl_akhir;
            if (!empty($params)) $pdfUrl .= '?' . http_build_query($params);
          ?>
          <a href="<?= $pdfUrl ?>" target="_blank" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Cetak Arus Kas (PDF)
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="get" action="<?= site_url('aruskas') ?>" class="mb-4">
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
              <a href="<?= site_url('aruskas') ?>" class="btn btn-secondary">
                Reset
              </a>
            </div>
          </div>
        </form>

        <!-- KPI Summary Cards -->
        <div class="row mb-4">
          <div class="col-md-3">
            <div class="card card-statistic-1 mb-0 border shadow-none bg-light">
              <div class="card-icon bg-primary">
                <i class="fas fa-cogs"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Arus Kas Operasi</h4>
                </div>
                <div class="card-body font-weight-bold" style="font-size: 16px;">
                  Rp <?= number_format($netOperasi) ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-statistic-1 mb-0 border shadow-none bg-light">
              <div class="card-icon bg-warning">
                <i class="fas fa-chart-line"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Arus Kas Investasi</h4>
                </div>
                <div class="card-body font-weight-bold" style="font-size: 16px;">
                  Rp <?= number_format($netInvestasi) ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-statistic-1 mb-0 border shadow-none bg-light">
              <div class="card-icon bg-info">
                <i class="fas fa-hand-holding-usd"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Arus Kas Pendanaan</h4>
                </div>
                <div class="card-body font-weight-bold" style="font-size: 16px;">
                  Rp <?= number_format($netPendanaan) ?>
                </div>
              </div>
            </div>
          </div>
          <div class="col-md-3">
            <div class="card card-statistic-1 mb-0 border shadow-none bg-light">
              <div class="card-icon bg-success">
                <i class="fas fa-wallet"></i>
              </div>
              <div class="card-wrap">
                <div class="card-header">
                  <h4>Saldo Akhir Kas</h4>
                </div>
                <div class="card-body font-weight-bold text-success" style="font-size: 16px;">
                  Rp <?= number_format($saldoAkhir) ?>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="table-responsive">
          <table class="table table-bordered table-md">
            <tbody>
              <!-- 1. AKTIVITAS OPERASI -->
              <tr class="table-secondary font-weight-bold">
                <td colspan="2"><i class="fas fa-briefcase mr-2"></i> ARUS KAS DARI AKTIVITAS OPERASI</td>
              </tr>
              <tr>
                <td colspan="2" class="font-weight-bold text-dark pl-4"><u>Penerimaan Kas:</u></td>
              </tr>
              <?php if (empty($operasiMasuk)) : ?>
                <tr>
                  <td class="pl-5 text-muted font-italic">Tidak ada penerimaan operasi</td>
                  <td class="text-right">Rp 0</td>
                </tr>
              <?php else : ?>
                <?php foreach ($operasiMasuk as $ket => $nom) : ?>
                  <tr>
                    <td class="pl-5"><?= $ket ?></td>
                    <td class="text-right text-success">Rp <?= number_format($nom) ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>

              <tr>
                <td colspan="2" class="font-weight-bold text-dark pl-4 pt-3"><u>Pengeluaran Kas:</u></td>
              </tr>
              <?php if (empty($operasiKeluar)) : ?>
                <tr>
                  <td class="pl-5 text-muted font-italic">Tidak ada pengeluaran operasi</td>
                  <td class="text-right">Rp 0</td>
                </tr>
              <?php else : ?>
                <?php foreach ($operasiKeluar as $ket => $nom) : ?>
                  <tr>
                    <td class="pl-5"><?= $ket ?></td>
                    <td class="text-right text-danger">(Rp <?= number_format($nom) ?>)</td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>

              <tr class="font-weight-bold bg-light">
                <td class="pl-4">Arus Kas Bersih dari Aktivitas Operasi</td>
                <td class="text-right" style="color: <?= $netOperasi >= 0 ? '#28a745' : '#dc3545' ?>;">
                  Rp <?= number_format($netOperasi) ?>
                </td>
              </tr>

              <!-- 2. AKTIVITAS INVESTASI -->
              <tr class="table-secondary font-weight-bold">
                <td colspan="2"><i class="fas fa-building mr-2"></i> ARUS KAS DARI AKTIVITAS INVESTASI</td>
              </tr>
              <?php if (empty($investasiMasuk) && empty($investasiKeluar)) : ?>
                <tr>
                  <td class="pl-5 text-muted font-italic">Tidak ada mutasi kas untuk aktivitas investasi pada periode ini</td>
                  <td class="text-right">Rp 0</td>
                </tr>
              <?php else : ?>
                <?php foreach ($investasiMasuk as $ket => $nom) : ?>
                  <tr>
                    <td class="pl-5"><?= $ket ?></td>
                    <td class="text-right text-success">Rp <?= number_format($nom) ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php foreach ($investasiKeluar as $ket => $nom) : ?>
                  <tr>
                    <td class="pl-5"><?= $ket ?></td>
                    <td class="text-right text-danger">(Rp <?= number_format($nom) ?>)</td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>

              <tr class="font-weight-bold bg-light">
                <td class="pl-4">Arus Kas Bersih dari Aktivitas Investasi</td>
                <td class="text-right" style="color: <?= $netInvestasi >= 0 ? '#28a745' : '#dc3545' ?>;">
                  Rp <?= number_format($netInvestasi) ?>
                </td>
              </tr>

              <!-- 3. AKTIVITAS PENDANAAN -->
              <tr class="table-secondary font-weight-bold">
                <td colspan="2"><i class="fas fa-coins mr-2"></i> ARUS KAS DARI AKTIVITAS PENDANAAN</td>
              </tr>
              <?php if (empty($pendanaanMasuk) && empty($pendanaanKeluar)) : ?>
                <tr>
                  <td class="pl-5 text-muted font-italic">Tidak ada mutasi kas untuk aktivitas pendanaan pada periode ini</td>
                  <td class="text-right">Rp 0</td>
                </tr>
              <?php else : ?>
                <?php foreach ($pendanaanMasuk as $ket => $nom) : ?>
                  <tr>
                    <td class="pl-5"><?= $ket ?></td>
                    <td class="text-right text-success">Rp <?= number_format($nom) ?></td>
                  </tr>
                <?php endforeach; ?>
                <?php foreach ($pendanaanKeluar as $ket => $nom) : ?>
                  <tr>
                    <td class="pl-5"><?= $ket ?></td>
                    <td class="text-right text-danger">(Rp <?= number_format($nom) ?>)</td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>

              <tr class="font-weight-bold bg-light">
                <td class="pl-4">Arus Kas Bersih dari Aktivitas Pendanaan</td>
                <td class="text-right" style="color: <?= $netPendanaan >= 0 ? '#28a745' : '#dc3545' ?>;">
                  Rp <?= number_format($netPendanaan) ?>
                </td>
              </tr>

              <!-- REKONSILIASI KAS -->
              <tr class="font-weight-bold table-info">
                <td>KENAIKAN / (PENURUNAN) BERSIH KAS</td>
                <td class="text-right">Rp <?= number_format($kenaikanKas) ?></td>
              </tr>
              <tr>
                <td class="font-weight-bold">SALDO KAS AWAL PERIODE</td>
                <td class="text-right font-weight-bold">Rp <?= number_format($saldoAwal) ?></td>
              </tr>
            </tbody>
            <tfoot>
              <tr class="font-weight-bold table-primary" style="font-size: 15px;">
                <td class="text-uppercase font-weight-bold">
                  SALDO KAS AKHIR PERIODE
                </td>
                <td class="text-right font-weight-bold text-primary">
                  Rp <?= number_format($saldoAkhir) ?>
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
