<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Tambah Transaksi Penyesuaian</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <a href="<?= site_url('penyesuaian') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
  </div>

  <div class="section-body">
      <div class="card">
        <div class="card-header">
            <h4>Tambah Data Transaksi Penyesuaian</h4>
        </div>
        <div class="card-body p-4">
            
            <form method="post" action="<?= site_url('penyesuaian') ?>">
            <?= csrf_field() ?>

            <div class="form-group">
              <label>Tanggal</label>
              <input type="date" class="form-control" name="tanggal" placeholder="Tanggal" required>
            </div>

            <div class="form-group">
              <label>Deskripsi</label>
              <input type="text" class="form-control" name="deskripsi" placeholder="Deskripsi Penyesuaian" required>
            </div>

            <div class="form-group">
              <label>Ket Jurnal</label>
              <input type="text" class="form-control" name="ketjurnal" value="Penyesuaian" readonly required>
            </div>

            <div class="box-body">
              <table class="table table-bordered" id="tableLoop">
                <thead>
                    <tr>
                      <th class="text-center" style="width: 5%">No</th>
                      <th style="width: 30%">Kode Akun</th>
                      <th style="width: 20%">Debit</th>
                      <th style="width: 20%">Kredit</th>
                      <th style="width: 15%">Status</th>
                      <th class="text-center" style="width: 10%">
                          <button class="btn btn-primary btn-sm btn-block" id="Barisbaru"><i class="fa fa-plus"></i> Add Baris</button>
                      </th>
                    </tr>
                </thead>
                <tbody>
                    <!-- Form dinamis yang di-generate dengan jQuery -->
                </tbody>
              </table>
            </div>

            <div>
              <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Save</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
          </form>

        </div>
      </div>
  </div>

</section>
<?= $this->endSection() ?>
