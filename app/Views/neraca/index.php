<?= $this->extend('layout/backend') ?>

<?= $this->section("content") ?>
<title>SIA-IPB &mdash; Laporan Neraca</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <h1>Laporan Neraca (Posisi Keuangan)</h1>
    <div class="section-header-breadcrumb">
      <div class="breadcrumb-item active"><a href="<?= site_url('/') ?>">Dashboard</a></div>
      <div class="breadcrumb-item">Laporan Keuangan</div>
      <div class="breadcrumb-item">Neraca</div>
    </div>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Filter Periode Laporan Posisi Keuangan</h4>
        <div class="card-header-action">
          <a href="<?= site_url('neraca/neracapdf' . ($tgl_awal && $tgl_akhir ? '?tgl_awal=' . $tgl_awal . '&tgl_akhir=' . $tgl_akhir : '')) ?>" target="_blank" class="btn btn-danger">
            <i class="fas fa-file-pdf"></i> Cetak PDF
          </a>
        </div>
      </div>
      <div class="card-body">
        <form method="get" action="<?= site_url('neraca') ?>" class="mb-4">
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
              <a href="<?= site_url('neraca') ?>" class="btn btn-secondary">
                Reset
              </a>
            </div>
          </div>
        </form>

        <?php 
          $isBalance = (round($totAktiva) == round($totPasiva));
        ?>

        <!-- Indikator Keseimbangan (Balance Alert) -->
        <div class="alert <?= $isBalance ? 'alert-success' : 'alert-danger' ?> alert-has-icon mb-4">
          <div class="alert-icon"><i class="fas <?= $isBalance ? 'fa-check-circle' : 'fa-exclamation-triangle' ?>"></i></div>
          <div class="alert-body">
            <div class="alert-title"><?= $isBalance ? 'Status: SEIMBANG (BALANCE)' : 'Status: TIDAK SEIMBANG' ?></div>
            Total Aktiva: <strong>Rp <?= number_format($totAktiva, 0, ',', '.') ?></strong> &nbsp;|&nbsp; 
            Total Pasiva (Kewajiban + Modal): <strong>Rp <?= number_format($totPasiva, 0, ',', '.') ?></strong>
          </div>
        </div>

        <div class="row">
          <!-- Kolom Kiri: AKTIVA -->
          <div class="col-lg-6">
            <div class="card card-primary border shadow-none mb-3">
              <div class="card-header bg-light py-2">
                <h5 class="text-primary mb-0 font-weight-bold">AKTIVA (ASSETS)</h5>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-sm mb-0">
                    <thead class="bg-light">
                      <tr>
                        <th colspan="2" class="font-weight-bold text-dark">Aktiva Lancar</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($aktivaLancar as $al) : ?>
                        <tr>
                          <td class="pl-4">
                            <span class="text-muted mr-1">[<?= $al['kode_akun3'] ?>]</span> <?= $al['nama_akun3'] ?>
                          </td>
                          <td class="text-right">Rp <?= number_format($al['saldo'], 0, ',', '.') ?></td>
                        </tr>
                      <?php endforeach; ?>
                      <tr class="font-weight-bold bg-light">
                        <td class="pl-3">Total Aktiva Lancar</td>
                        <td class="text-right text-dark">Rp <?= number_format($totAktivaLancar, 0, ',', '.') ?></td>
                      </tr>
                    </tbody>

                    <thead class="bg-light">
                      <tr>
                        <th colspan="2" class="font-weight-bold text-dark pt-3">Aktiva Tetap</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($aktivaTetap as $at) : ?>
                        <tr>
                          <td class="pl-4">
                            <span class="text-muted mr-1">[<?= $at['kode_akun3'] ?>]</span> <?= $at['nama_akun3'] ?>
                          </td>
                          <td class="text-right <?= $at['is_contra'] ? 'text-danger' : '' ?>">
                            <?= $at['is_contra'] ? '(Rp ' . number_format(abs($at['saldo']), 0, ',', '.') . ')' : 'Rp ' . number_format($at['saldo'], 0, ',', '.') ?>
                          </td>
                        </tr>
                      <?php endforeach; ?>
                      <tr class="font-weight-bold bg-light">
                        <td class="pl-3">Total Aktiva Tetap</td>
                        <td class="text-right text-dark">Rp <?= number_format($totAktivaTetap, 0, ',', '.') ?></td>
                      </tr>
                    </tbody>

                    <tfoot>
                      <tr class="table-primary font-weight-bold" style="font-size: 15px;">
                        <td>TOTAL AKTIVA</td>
                        <td class="text-right">Rp <?= number_format($totAktiva, 0, ',', '.') ?></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>

          <!-- Kolom Kanan: PASIVA (KEWAJIBAN & MODAL) -->
          <div class="col-lg-6">
            <div class="card card-primary border shadow-none mb-3">
              <div class="card-header bg-light py-2">
                <h5 class="text-primary mb-0 font-weight-bold">PASIVA (LIABILITIES & EQUITY)</h5>
              </div>
              <div class="card-body p-0">
                <div class="table-responsive">
                  <table class="table table-sm mb-0">
                    <thead class="bg-light">
                      <tr>
                        <th colspan="2" class="font-weight-bold text-dark">Kewajiban (Utang Lancar)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <?php foreach ($kewajiban as $kw) : ?>
                        <tr>
                          <td class="pl-4">
                            <span class="text-muted mr-1">[<?= $kw['kode_akun3'] ?>]</span> <?= $kw['nama_akun3'] ?>
                          </td>
                          <td class="text-right">Rp <?= number_format($kw['saldo'], 0, ',', '.') ?></td>
                        </tr>
                      <?php endforeach; ?>
                      <tr class="font-weight-bold bg-light">
                        <td class="pl-3">Total Kewajiban</td>
                        <td class="text-right text-dark">Rp <?= number_format($totKewajiban, 0, ',', '.') ?></td>
                      </tr>
                    </tbody>

                    <thead class="bg-light">
                      <tr>
                        <th colspan="2" class="font-weight-bold text-dark pt-3">Ekuitas (Modal)</th>
                      </tr>
                    </thead>
                    <tbody>
                      <tr>
                        <td class="pl-4">
                          Modal Pemilik
                        </td>
                        <td class="text-right font-weight-bold">Rp <?= number_format($modalPemilik, 0, ',', '.') ?></td>
                      </tr>
                      <tr>
                        <td class="pl-4">
                          Laba Ditahan
                        </td>
                        <td class="text-right font-weight-bold">Rp <?= number_format($labaDitahan, 0, ',', '.') ?></td>
                      </tr>
                      <tr class="font-weight-bold bg-light">
                        <td class="pl-3">Total Ekuitas</td>
                        <td class="text-right text-dark">Rp <?= number_format($totEkuitas, 0, ',', '.') ?></td>
                      </tr>
                    </tbody>

                    <tfoot>
                      <tr class="table-primary font-weight-bold" style="font-size: 15px;">
                        <td>TOTAL PASIVA</td>
                        <td class="text-right">Rp <?= number_format($totPasiva, 0, ',', '.') ?></td>
                      </tr>
                    </tfoot>
                  </table>
                </div>
              </div>
            </div>
          </div>
        </div>

      </div>
    </div>
  </div>

</section>

<?= $this->endSection() ?>
