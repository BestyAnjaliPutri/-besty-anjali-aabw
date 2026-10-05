<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Laporan Perubahan Modal</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <h1>Laporan Perubahan Modal</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Laporan Perubahan Modal (Statement of Owner's Equity)</h4>
        <div>
          <?php 
            $pdfUrl = site_url('perubahanmodal/perubahanmodalpdf');
            $params = [];
            if (!empty($tgl_awal)) $params['tgl_awal'] = $tgl_awal;
            if (!empty($tgl_akhir)) $params['tgl_akhir'] = $tgl_akhir;
            if (!empty($params)) $pdfUrl .= '?' . http_build_query($params);
          ?>
          <a href="<?= $pdfUrl ?>" target="_blank" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Cetak Perubahan Modal (PDF)
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="get" action="<?= site_url('perubahanmodal') ?>" class="mb-4">
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
              <a href="<?= site_url('perubahanmodal') ?>" class="btn btn-secondary">
                Reset
              </a>
            </div>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-bordered table-md">
            <tbody>
              <tr>
                <td style="width: 70%" class="font-weight-bold">Modal Awal Pemilik</td>
                <td style="width: 30%" class="text-right font-weight-bold">
                  Rp <?= number_format($modalAwal) ?>
                </td>
              </tr>
              <tr>
                <td class="pl-4">
                  <i class="fas fa-plus text-success mr-2"></i> Laba Bersih Periode Berjalan
                </td>
                <td class="text-right text-success font-weight-bold">
                  Rp <?= number_format($labaBersih) ?>
                </td>
              </tr>
              <tr>
                <td class="pl-4">
                  <i class="fas fa-minus text-danger mr-2"></i> Prive Pemilik (Pengambilan Pribadi)
                </td>
                <td class="text-right text-danger font-weight-bold">
                  (Rp <?= number_format($prive) ?>)
                </td>
              </tr>
              <tr class="table-active font-weight-bold">
                <td>
                  <?= $perubahanNet >= 0 ? 'Kenaikan Bersih Modal' : 'Penurunan Bersih Modal' ?>
                </td>
                <td class="text-right" style="color: <?= $perubahanNet >= 0 ? '#28a745' : '#dc3545' ?>;">
                  Rp <?= number_format($perubahanNet) ?>
                </td>
              </tr>
            </tbody>
            <tfoot>
              <tr class="font-weight-bold table-primary" style="font-size: 15px;">
                <td class="text-uppercase font-weight-bold">
                  MODAL AKHIR PERIODE
                </td>
                <td class="text-right font-weight-bold text-primary">
                  Rp <?= number_format($modalAkhir) ?>
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
