<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Edit Transaksi</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <a href="<?= site_url('transaksi') ?>" class="btn btn-primary"><i class="fas fa-arrow-left"></i> Back</a>
  </div>

  <div class="section-body">
      <div class="card">
        <div class="card-header">
            <h4>Edit Data Transaksi</h4>
        </div>
        <div class="card-body p-4">
            
          <form method="post" action="<?= site_url('transaksi/' . $dttransaksi->id_transaksi) ?>">
            <?= csrf_field() ?>
            <input type="hidden" name="_method" value="PUT">
            
            <div class="form-group">
              <label>Tanggal</label>
              <input type="date" class="form-control" name="tanggal" placeholder="Tanggal" required value="<?= date('Y-m-d', strtotime($dttransaksi->tanggal)) ?>">
            </div>

            <div class="form-group">
              <label>Deskripsi</label>
              <input type="text" class="form-control" name="deskripsi" placeholder="Deskripsi" required value="<?= $dttransaksi->deskripsi ?>">
            </div>

            <div class="form-group">
              <label>Ket Jurnal</label>
              <input type="text" name="ketjurnal" class="form-control" placeholder="Ket Jurnal" required value="<?= $dttransaksi->ketjurnal ?>">
            </div>

            <div class="box-body">
              <table class="table table-bordered">
                <thead>
                    <tr>
                      <th class="text-center" style="width: 5%">No</th>
                      <th style="width: 35%">Kode Akun</th>
                      <th style="width: 20%">Debit</th>
                      <th style="width: 20%">Kredit</th>
                      <th style="width: 20%">Status</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $i = 0; ?>
                    <?php foreach ($dtnilai as $item) : ?>
                        <?php 
                            $i++; 
                            $item = (object) $item; 
                        ?>
                        <tr>
                            <input type="hidden" name="id_nilai[]" value="<?= $item->id_nilai ?>">
                            <td class="text-center"><?= $i ?></td>
                            <td>
                                <select name="kode_akun3[]" class="form-control" required>
                                    <option value="">- Pilih Akun -</option>
                                    <?php foreach ($dtakun3 as $value) : ?>
                                        <?php 
                                            $val = (object) $value; 
                                            $namaAkun = $val->nama_akun3 ?? $val->nama_akun ?? '';
                                        ?>
                                        <option value="<?= $val->kode_akun3 ?>" <?= ($item->kode_akun3 == $val->kode_akun3) ? 'selected' : '' ?>>
                                            <?= $val->kode_akun3 ?> | <?= $namaAkun ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                            <td>
                                <input type="number" name="debet[]" class="form-control" value="<?= $item->debet ?? $item->debit ?? 0 ?>" min="0" required>
                            </td>
                            <td>
                                <input type="number" name="kredit[]" class="form-control" value="<?= $item->kredit ?? 0 ?>" min="0" required>
                            </td>
                            <td>
                                <select name="id_status[]" class="form-control" required>
                                    <option value="">- Pilih Status -</option>
                                    <?php foreach ($dtstatus as $value) : ?>
                                        <?php $st = (object) $value; ?>
                                        <option value="<?= $st->id_status ?>" <?= ($item->id_status == $st->id_status) ? 'selected' : '' ?>>
                                            <?= $st->status ?>
                                        </option>
                                    <?php endforeach; ?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>                    
              </table>
            </div>

            <div>
              <button type="submit" class="btn btn-success"><i class="fas fa-paper-plane"></i> Update</button>
              <button type="reset" class="btn btn-secondary">Reset</button>
            </div>
          </form>

        </div>
      </div>
  </div>

</section>
<?= $this->endSection() ?>
