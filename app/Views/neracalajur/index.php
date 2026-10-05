<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Neraca Lajur</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <h1>Neraca Lajur</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Neraca Lajur (Kertas Kerja 10 Kolom)</h4>
        <div>
          <?php 
            $pdfUrl = site_url('neracalajur/neracalajurpdf');
            $params = [];
            if (!empty($tgl_awal)) $params['tgl_awal'] = $tgl_awal;
            if (!empty($tgl_akhir)) $params['tgl_akhir'] = $tgl_akhir;
            if (!empty($params)) $pdfUrl .= '?' . http_build_query($params);
          ?>
          <a href="<?= $pdfUrl ?>" target="_blank" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Cetak Neraca Lajur (PDF)
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="get" action="<?= site_url('neracalajur') ?>" class="mb-4">
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
              <a href="<?= site_url('neracalajur') ?>" class="btn btn-secondary">
                Reset
              </a>
            </div>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-bordered table-sm table-striped" style="font-size: 12px;">
            <thead>
              <tr class="text-center" style="background-color: #e9ecef;">
                <th rowspan="2" class="align-middle" style="width: 7%">Kode Akun</th>
                <th rowspan="2" class="align-middle" style="width: 17%">Nama Akun</th>
                <th colspan="2">Neraca Saldo</th>
                <th colspan="2">Penyesuaian</th>
                <th colspan="2">NS Disesuaikan</th>
                <th colspan="2">Laba / Rugi</th>
                <th colspan="2">Neraca</th>
              </tr>
              <tr class="text-center" style="background-color: #f4f6f9;">
                <th style="width: 7.5%">Debit</th>
                <th style="width: 7.5%">Kredit</th>
                <th style="width: 7.5%">Debit</th>
                <th style="width: 7.5%">Kredit</th>
                <th style="width: 7.5%">Debit</th>
                <th style="width: 7.5%">Kredit</th>
                <th style="width: 7.5%">Debit</th>
                <th style="width: 7.5%">Kredit</th>
                <th style="width: 7.5%">Debit</th>
                <th style="width: 7.5%">Kredit</th>
              </tr>
            </thead>
            <tbody>
              <?php foreach ($dtlajur as $row) : ?>
                <tr>
                  <td class="text-center"><?= $row->kode_akun3 ?></td>
                  <td><?= $row->nama_akun3 ?></td>
                  <td class="text-right"><?= $row->ns_debet > 0 ? number_format($row->ns_debet) : '-' ?></td>
                  <td class="text-right"><?= $row->ns_kredit > 0 ? number_format($row->ns_kredit) : '-' ?></td>
                  <td class="text-right"><?= $row->ajp_debet > 0 ? number_format($row->ajp_debet) : '-' ?></td>
                  <td class="text-right"><?= $row->ajp_kredit > 0 ? number_format($row->ajp_kredit) : '-' ?></td>
                  <td class="text-right"><?= $row->nsd_debet > 0 ? number_format($row->nsd_debet) : '-' ?></td>
                  <td class="text-right"><?= $row->nsd_kredit > 0 ? number_format($row->nsd_kredit) : '-' ?></td>
                  <td class="text-right"><?= $row->lr_debet > 0 ? number_format($row->lr_debet) : '-' ?></td>
                  <td class="text-right"><?= $row->lr_kredit > 0 ? number_format($row->lr_kredit) : '-' ?></td>
                  <td class="text-right"><?= $row->n_debet > 0 ? number_format($row->n_debet) : '-' ?></td>
                  <td class="text-right"><?= $row->n_kredit > 0 ? number_format($row->n_kredit) : '-' ?></td>
                </tr>
              <?php endforeach; ?>
            </tbody>
            <tfoot>
              <!-- Baris Total Sebelum Laba/Rugi -->
              <tr class="font-weight-bold" style="background-color: #f4f6f9;">
                <td colspan="2" class="text-center">TOTAL</td>
                <td class="text-right"><?= number_format($tot_ns_debet) ?></td>
                <td class="text-right"><?= number_format($tot_ns_kredit) ?></td>
                <td class="text-right"><?= number_format($tot_ajp_debet) ?></td>
                <td class="text-right"><?= number_format($tot_ajp_kredit) ?></td>
                <td class="text-right"><?= number_format($tot_nsd_debet) ?></td>
                <td class="text-right"><?= number_format($tot_nsd_kredit) ?></td>
                <td class="text-right"><?= number_format($tot_lr_debet) ?></td>
                <td class="text-right"><?= number_format($tot_lr_kredit) ?></td>
                <td class="text-right"><?= number_format($tot_n_debet) ?></td>
                <td class="text-right"><?= number_format($tot_n_kredit) ?></td>
              </tr>
              <!-- Baris Laba / Rugi Bersih -->
              <tr class="font-weight-bold table-info">
                <td colspan="2" class="text-center text-primary">
                  <?= $laba_bersih >= 0 ? 'LABA BERSIH' : 'RUGI BERSIH' ?>
                </td>
                <td colspan="6" class="text-center text-muted">-</td>
                <td class="text-right"><?= $laba_bersih >= 0 ? number_format($laba_bersih) : '-' ?></td>
                <td class="text-right"><?= $laba_bersih < 0 ? number_format(abs($laba_bersih)) : '-' ?></td>
                <td class="text-right"><?= $laba_bersih < 0 ? number_format(abs($laba_bersih)) : '-' ?></td>
                <td class="text-right"><?= $laba_bersih >= 0 ? number_format($laba_bersih) : '-' ?></td>
              </tr>
              <!-- Baris Total Seimbang -->
              <tr class="font-weight-bold" style="background-color: #e9ecef;">
                <td colspan="2" class="text-center">BALANCE</td>
                <td class="text-right"><?= number_format($tot_ns_debet) ?></td>
                <td class="text-right"><?= number_format($tot_ns_kredit) ?></td>
                <td class="text-right"><?= number_format($tot_ajp_debet) ?></td>
                <td class="text-right"><?= number_format($tot_ajp_kredit) ?></td>
                <td class="text-right"><?= number_format($tot_nsd_debet) ?></td>
                <td class="text-right"><?= number_format($tot_nsd_kredit) ?></td>
                <td class="text-right"><?= number_format(max($tot_lr_debet, $tot_lr_kredit)) ?></td>
                <td class="text-right"><?= number_format(max($tot_lr_debet, $tot_lr_kredit)) ?></td>
                <td class="text-right"><?= number_format(max($tot_n_debet, $tot_n_kredit)) ?></td>
                <td class="text-right"><?= number_format(max($tot_n_debet, $tot_n_kredit)) ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>
<?= $this->endSection() ?>
