<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Jurnal Umum</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <h1>Jurnal Umum</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Filter Periode Jurnal Umum</h4>
      </div>
      <div class="card-body p-4">
        <form method="get" action="<?= site_url('jurnalumum') ?>">
          <div class="row align-items-end">
            <div class="col-md-3">
              <label>Tanggal Awal</label>
              <input type="date" name="tgl_awal" class="form-control" value="<?= $tgl_awal ?? '' ?>">
            </div>
            <div class="col-md-3">
              <label>Tanggal Akhir</label>
              <input type="date" name="tgl_akhir" class="form-control" value="<?= $tgl_akhir ?? '' ?>">
            </div>
            <div class="col-md-6 mt-3 mt-md-0">
              <button type="submit" class="btn btn-primary mr-2">
                <i class="fas fa-filter"></i> Filter
              </button>
              <a href="<?= site_url('jurnalumum') ?>" class="btn btn-secondary mr-2">
                <i class="fas fa-undo"></i> Reset
              </a>
              <?php 
                $printUrl = site_url('jurnalumum/cetakjurnal');
                if (!empty($tgl_awal) && !empty($tgl_akhir)) {
                    $printUrl .= '?tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir;
                }
              ?>
              <a href="<?= $printUrl ?>" target="_blank" class="btn btn-success float-md-right mt-2 mt-md-0">
                <i class="fas fa-print"></i> Cetak Laporan
              </a>
            </div>
          </div>
        </form>
      </div>
    </div>

    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Tabel Jurnal Umum</h4>
        <?php if ($totDebet == $totKredit) : ?>
          <span class="badge badge-success font-weight-bold px-3 py-2"><i class="fas fa-check-circle"></i> BALANCE</span>
        <?php else : ?>
          <span class="badge badge-danger font-weight-bold px-3 py-2"><i class="fas fa-exclamation-triangle"></i> TIDAK BALANCE</span>
        <?php endif; ?>
      </div>
      <div class="card-body p-4">
        <div class="table-responsive">
          <table class="table table-bordered table-md">
            <thead>
              <tr class="text-center" style="background-color: #f4f6f9;">
                <th style="width: 12%">Tanggal</th>
                <th style="width: 10%">Kwitansi</th>
                <th style="width: 40%">Keterangan / Nama Akun</th>
                <th style="width: 10%">Ref</th>
                <th style="width: 14%">Debit (Rp)</th>
                <th style="width: 14%">Kredit (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($dtjurnal)) : ?>
                <tr>
                  <td colspan="6" class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                    Belum ada data jurnal pada periode ini.
                  </td>
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
                    <td class="text-center align-middle">
                      <?= $isFirstInTx ? date('d/m/Y', strtotime($row->tanggal)) : '' ?>
                    </td>
                    <td class="text-center align-middle">
                      <?= $isFirstInTx ? $row->kwitansi : '' ?>
                    </td>
                    <td class="align-middle">
                      <?php if ($valDebet > 0) : ?>
                        <span class="font-weight-bold text-dark"><?= $row->nama_akun3 ?></span>
                      <?php else : ?>
                        <span style="padding-left: 28px; font-style: italic; color: #495057;"><?= $row->nama_akun3 ?></span>
                      <?php endif; ?>
                    </td>
                    <td class="text-center align-middle"><?= $row->kode_akun3 ?></td>
                    <td class="text-right align-middle">
                      <?= $valDebet > 0 ? number_format($valDebet, 0, ',', '.') : '-' ?>
                    </td>
                    <td class="text-right align-middle">
                      <?= $valKredit > 0 ? number_format($valKredit, 0, ',', '.') : '-' ?>
                    </td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
            <tfoot>
              <tr class="font-weight-bold" style="background-color: #f4f6f9;">
                <td colspan="4" class="text-center font-weight-bold">TOTAL</td>
                <td class="text-right font-weight-bold">Rp <?= number_format($totDebet, 0, ',', '.') ?></td>
                <td class="text-right font-weight-bold">Rp <?= number_format($totKredit, 0, ',', '.') ?></td>
              </tr>
            </tfoot>
          </table>
        </div>
      </div>
    </div>
  </div>

</section>
<?= $this->endSection() ?>
