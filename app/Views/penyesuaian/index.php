<?= $this->extend('layout/backend') ?>

<?= $this->section("title") ?>
<title>SIA-IPB &mdash; Transaksi Penyesuaian</title>
<?= $this->endSection() ?>

<?= $this->section("content") ?>

<section class="section">
  <div class="section-header">
    <a href="<?= site_url('penyesuaian/new') ?>" class="btn btn-primary"><i class="fas fa-plus"></i> Add New</a>
  </div>

  <!-- flashdata message -->
  <?php if (session()->getFlashdata('success')) : ?>
    <div class="alert alert-success alert-dismissible show fade">
      <div class="alert-body">
        <button class="close" data-dismiss="alert"> &times; </button>
        <?= session()->getFlashdata('success') ?>
      </div>
    </div>
  <?php endif; ?>

  <?php if (session()->getFlashdata('error')) : ?>
    <div class="alert alert-danger alert-dismissible show fade">
      <div class="alert-body">
        <button class="close" data-dismiss="alert"> &times; </button>
        <?= session()->getFlashdata('error') ?>
      </div>
    </div>
  <?php endif; ?>

  <div class="section-body">
      <div class="card">
          <div class="card-header">
            <h4>Data Transaksi Penyesuaian</h4>
          </div>
          <div class="card-body p-4">
            <div class="table-responsive">
              <table class="table table-striped table-md" id="myTable">
                <thead>
                  <tr>
                      <th class="text-center" style="width: 5%">No</th>
                      <th>Kwitansi</th>
                      <th>Tanggal</th>
                      <th>Deskripsi</th>
                      <th>Ket Jurnal</th>
                      <th class="text-center" style="width: 25%">Action</th>
                  </tr>
                </thead>
                <tbody>
                    <?php foreach ($dtpenyesuaian as $key => $value) : ?>
                    <tr>
                        <td class="text-center"><?= $key + 1 ?></td>
                        <td><?= $value->kwitansi ?></td>
                        <td><?= date('d/m/Y', strtotime($value->tanggal)) ?></td>
                        <td><?= $value->deskripsi ?></td>
                        <td><span class="badge badge-warning"><?= $value->ketjurnal ?></span></td>
                        <td class="text-center">
                            <a href="<?= site_url('penyesuaian/' . $value->id_transaksi) ?>" class="btn btn-info btn-sm">
                                <i class="fas fa-bars"></i> Detail
                            </a>
                            <a href="<?= site_url('penyesuaian/' . $value->id_transaksi . '/edit') ?>" class="btn btn-warning btn-sm">
                                <i class="fas fa-pencil-alt"></i> Edit
                            </a>
                            <form action="<?= site_url('penyesuaian/' . $value->id_transaksi) ?>" method="post" id="del-<?= $value->id_transaksi ?>" class="d-inline">
                                <?= csrf_field() ?>
                                <input type="hidden" name="_method" value="DELETE">
                                <button type="submit" class="btn btn-danger btn-sm" data-confirm="Hapus Data...? | Apakah Anda yakin ingin menghapus data ini...?" data-confirm-yes="hapus(<?= $value->id_transaksi ?>)">
                                    <i class="fas fa-trash"></i> Delete
                                </button>
                            </form>
                        </td>
                    </tr>
                    <?php endforeach; ?>
                </tbody>                   
              </table>
            </div>
          </div>
        </div>
  </div>

</section>
<?= $this->endSection() ?>
