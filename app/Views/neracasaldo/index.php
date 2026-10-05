<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Neraca Saldo</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <h1>Neraca Saldo</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header d-flex justify-content-between align-items-center">
        <h4>Neraca Saldo</h4>
        <div>
          <?php 
            $printUrl = site_url('neracasaldo/neracasaldopdf');
            $params = [];
            if (!empty($tgl_awal)) $params['tgl_awal'] = $tgl_awal;
            if (!empty($tgl_akhir)) $params['tgl_akhir'] = $tgl_akhir;
            if (!empty($params)) $printUrl .= '?' . http_build_query($params);
          ?>
          <a href="<?= $printUrl ?>" target="_blank" class="btn btn-primary btn-sm">
            <i class="fas fa-file-pdf"></i> Cetak Neraca Saldo (PDF)
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="get" action="<?= site_url('neracasaldo') ?>" class="mb-4">
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
              <a href="<?= site_url('neracasaldo') ?>" class="btn btn-secondary">
                Reset
              </a>
            </div>
          </div>
        </form>

        <div class="table-responsive">
          <table class="table table-striped table-md">
            <thead>
              <tr style="background-color: #f4f6f9;">
                <th style="width: 5%" class="text-center">No</th>
                <th style="width: 15%">Kode Akun</th>
                <th style="width: 40%">Nama Akun</th>
                <th style="width: 20%" class="text-right">Debit (Rp)</th>
                <th style="width: 20%" class="text-right">Kredit (Rp)</th>
              </tr>
            </thead>
            <tbody>
              <?php if (empty($dtneraca)) : ?>
                <tr>
                  <td colspan="5" class="text-center text-muted py-4">
                    <i class="fas fa-info-circle fa-2x mb-2 d-block"></i>
                    Belum ada data neraca saldo pada periode ini.
                  </td>
                </tr>
              <?php else : ?>
                <?php foreach ($dtneraca as $key => $row) : ?>
                  <tr>
                    <td class="text-center"><?= $key + 1 ?></td>
                    <td><?= $row->kode_akun3 ?></td>
                    <td><?= $row->nama_akun3 ?></td>
                    <td class="text-right"><?= $row->debet > 0 ? number_format($row->debet) : '-' ?></td>
                    <td class="text-right"><?= $row->kredit > 0 ? number_format($row->kredit) : '-' ?></td>
                  </tr>
                <?php endforeach; ?>
              <?php endif; ?>
            </tbody>
            <?php if (!empty($dtneraca)) : ?>
              <tfoot>
                <tr class="font-weight-bold" style="background-color: #f4f6f9;">
                  <td colspan="3" class="text-center">
                    TOTAL
                    <?php if ($isBalance) : ?>
                      <span class="badge badge-success ml-2">BALANCE</span>
                    <?php else : ?>
                      <span class="badge badge-danger ml-2">TIDAK BALANCE</span>
                    <?php endif; ?>
                  </td>
                  <td class="text-right">Rp <?= number_format($totDebet) ?></td>
                  <td class="text-right">Rp <?= number_format($totKredit) ?></td>
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
