<?= $this->extend('layout/backend') ?>


<?= $this->section("content") ?>

<section class="section">
          <div class="section-header">
            <!-- <h1>Blank Page</h1> -->
            <a href="<?= site_url('akun2/new') ?>" class="btn btn-primary"></i> Back</a>
          </div>

          <div class="section-body">
              <!-- dinamis -->
              <div class="card">
                <div class="card-header">
                    <h4>Tambah Data Akun 2</h4>
                </div>
                <div class="card-body p-4">
                    
                    <form method="post" action="<?= site_url('akun2/post') ?>">
                    <?= csrf_field() ?>

                    <div class="form-group">
                    <label>Nama Akun 1</label>
                    <select name="kode_akun1" class="form-control" required>
                        <option value="">-- Pilih Akun 1 --</option>
                        <?php foreach ($dtakun1 as $key => $value) : ?>
                        <option value="<?= is_array($value) ? $value['kode_akun1'] : $value->kode_akun1 ?>">
                            <?= is_array($value) ? $value['nama_akun1'] : $value->nama_akun1 ?>
                        </option>
                        <?php endforeach; ?>
                    </select>
                    </div>
                    <div class="form-group">
                      <label>Kode Akun 2</label>
                      <input type="text" class="form-control" name="kode_akun2" placeholder="Kode Akun 2" required>
                    </div>
                     <div class="form-group">
                      <label>Nama Akun 2</label>
                      <input type="text" class="form-control" name="nama_akun2" placeholder="Nama Akun 2">
                    </div>
                    <div class="form-group">
                      <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Save</button>
                      <button type="reset" class="btn btn-secondary">Reset</button>
                  </div>
                    </form>

                </div>
          </div>

        </section>

<?= $this->endSection() ?>