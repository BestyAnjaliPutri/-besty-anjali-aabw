<?= $this->extend('layout/backend') ?>

<?= $this->section('content') ?>
<section class="section">
  <div class="section-header">
    <div class="section-header-back">
      <a href="<?= site_url('akun3') ?>" class="btn btn-icon"><i class="fas fa-arrow-left"></i></a>
    </div>
    <h1>Edit Data Akun 3</h1>
  </div>

  <div class="section-body">
    <div class="card">
      <div class="card-header">
        <h4>Edit Data Akun 3</h4>
      </div>
      <div class="card-body col-md-8">
        <form method="post" action="<?= site_url('akun3/' . $dtakun3->id_akun3) ?>" autocomplete="off">
          <?= csrf_field() ?>
          <input type="hidden" name="_method" value="PUT">

          <div class="form-group">
            <label>Nama Akun 1</label>
            <select name="kode_akun1" class="form-control" required>
              <option value="">-- Pilih Akun 1 --</option>
              <?php foreach ($dtakun1 as $key => $value) : ?>
                <option value="<?= $value->kode_akun1 ?>" <?= $value->kode_akun1 == $dtakun3->kode_akun1 ? 'selected' : '' ?>>
                  <?= $value->nama_akun1 ?>
                </option>
              <?php endforeach; ?>
            </select>
          </div>

<div class="form-group">
    <label>Pilih Akun 2</label>
    <select name="kode_akun2" class="form-control" required>
        <option value="">-- Pilih Akun 2 --</option>
        <?php foreach ($dtakun2 as $akun2) : ?>
            <option value="<?= $akun2->kode_akun2 ?>" <?= ($dtakun3->kode_akun2 == $akun2->kode_akun2) ? 'selected' : '' ?>>
                <?= $akun2->kode_akun2 ?> - <?= $akun2->nama_akun2 ?>
            </option>
        <?php endforeach; ?>
    </select>
</div>

<div class="form-group">
    <label>Kode Akun 3</label>
    <input type="text" class="form-control" name="kode_akun3" value="<?= $dtakun3->kode_akun3 ?>" placeholder="Kode Akun 3" required>
</div>

<div class="form-group">
    <label>Nama Akun 3</label>
    <input type="text" class="form-control" name="nama_akun3" value="<?= $dtakun3->nama_akun3 ?>" placeholder="Nama Akun 3" required>
</div>
          <div class="form-group">
            <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Update</button>
            <button type="reset" class="btn btn-secondary">Reset</button>
          </div>
        </form>
      </div>
    </div>
  </div>
</section>
<?= $this->endSection() ?>